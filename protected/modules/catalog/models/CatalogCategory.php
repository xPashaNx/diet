<?php

/**
 * This is the model class for table "catalog_category".
 *
 * The followings are the available columns in table 'catalog_category':
 * @property string $id
 * @property string $title
 * @property string $link
 * @property string $image
 *
 * The followings are the available model relations:
 * @property CatalogProduct[] $catalogProducts
 */
class CatalogCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, link, parent_id', 'required'),
			array('title, link, image, layout', 'length', 'max'=>256),
			array('link','unique', 'message' => 'Категория со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('keywords, description, text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, link, image, parent_id', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.modules.catalog.components.SSortable.SSortableCatalogBehavior',
                'categoryField' => 'parent_id',
			),
            'CAdvancedArBehavior' => array('class' => 'application.extensions.EAdvancedArBehavior.EAdvancedArBehavior')
		);

	}     

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catalogProducts' => array(self::HAS_MANY, 'CatalogProduct', 'id_category','condition'=>'catalogProducts.on_main=1', 'order'=>'sort_order'),
			'parent' => array(self::BELONGS_TO, 'CatalogCategory', 'parent_id'),
			'childs' => array(self::HAS_MANY, 'CatalogCategory', 'parent_id'),

            //атрибуты товаров, которые используются в данной категории
            'use_attribute' => array(self::MANY_MANY, 'CatalogAttribute', 'catalog_category_attribute(id_category, id_attribute)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родительская категория',
			'title' => 'Заголовок',
			'link' => 'Ссылка',
			'layout' => 'Шаблон страницы',
			'image' => 'Изображение',
            'keywords' => 'Ключевые слова (метатег keywords)',
            'description' => 'Описание (метатег description)',
            'text' => 'Описание категории',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(isset($_GET['id']))
			$this->parent_id=$_GET['id'];
		else $this->parent_id=0;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));
	}

    //****************************************************************************
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            // Читаем конфигурацию каталога
            $catalog_config=CatalogConfig::model()->findByPk(1);

            //Перед записью загружаем картинки

            $folder='upload/catalog/category';

            // Если это не новая запись - Берем старую модель для удаления старой картинки
            if(!$this->isNewRecord)
            {
               $old_model=CatalogCategory::model()->findByPk($this->id);
               $old_image=$old_model->image;
            }else{$old_image='';}

            // Сохраняем картинку, если она загружается
			if	($image = CUploadedFile::getInstance($this, 'image')){
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->image = $name;
				$image->saveAs($folder . '/' . $name);
				Yii::app()->ih
					->load($folder . '/' . $this->image)
					//->resize(349, false)
					//->crop(266, 266)
					//->resizeCanvas
                    ->resize($catalog_config->c_image_small_w, $catalog_config->c_image_small_h)
					->save($folder . '/small/' . $this->image,false,100);

                if($old_image){
                        //Удаляем старые картинки
                        @unlink($folder . '/' .$old_image);
                        @unlink($folder . '/small/' .$old_image);
                }

            // если ничего не загружается - записываем старое значение
			}else {$this->image = $old_image;}
			return true;
		}
		else
			return false;
	}


    //****************************************************************************
	public static function getListed($id=0, $first=true) 
	{
		$subitems = array();
		$space='';
		//if($first && $id==0) $subitems[0] = '---';

		foreach(CatalogCategory::model()->findAll('parent_id = ' . $id) as $model) {
			$space.=' ';
			$subitems[$model->id] = $space.$model->title;
			if ($items = CatalogCategory::getListed($model->id))
			foreach ($items as $key=>$value)
				$subitems[$key] = $value;
		}
		return $subitems;
	}

    //****************************************************************************
	public static function getParents($id, $product=false) {
		$data = array();
		if ($id!=0) {
			$parents = CatalogCategory::model()->findByPk($id);
				if ($product==true)$data[$parents->title] = array('/catalog/default/index', 'id'=>$parents->id);
				while ($parents = CatalogCategory::getParent($parents->parent_id)) {
					$data[$parents->title] = array('/catalog/default/index', 'id'=>$parents->id);
				}
			$data['Каталог услуг'] = array('/catalog/default/index');
		}
		return array_reverse($data);
	}

    //****************************************************************************
    // Возвращает массив из id дочерних
    public function getAllChildIds(){
        $allchilds=array();

        // критерии для выбора подкатегорий
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', $this->id);
        $criteria->order='sort_order ASC';

        $thischilds=CatalogCategory::model()->findAll($criteria);
        foreach($thischilds as $thischild){
            $allchilds[]=$thischild->id;
            $allchilds=array_merge($allchilds, $thischild->allChildIds);
        }

        return $allchilds;
    }

    //****************************************************************************
    // Возвращает массив из дочерних категорий для построения select-списка
    public function getAllChildsList($spaced=0){
        $allchilds=array();

        // критерии для выбора подкатегорий
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', $this->id);
        $criteria->order='sort_order ASC';

        $thischilds=CatalogCategory::model()->findAll($criteria);
        foreach($thischilds as $thischild){
            $allchilds[$thischild->id]=str_repeat ('___', $spaced).$thischild->title;
            $allchilds=$allchilds+$thischild->getAllChildsList($spaced+1);
        }

        return $allchilds;
    }
    //****************************************************************************
	public static function getParent($id) {
		$parent = CatalogCategory::model()->findByPk($id);
		return $parent;
	}

    //****************************************************************************
	public static function getBreadcrumbs($id,$product=true) {
        // Читаем конфигурацию каталога
        $catalog_config=CatalogConfig::model()->findByPk(1);

		$data = array();
		if ($id!=0) {
			$parents = CatalogCategory::model()->findByPk($id);
				if ($product==true)$data[$parents->title] = array('/catalog'.CatalogCategory::getCategoryRoute($parents->link));
				while ($parents = CatalogCategory::getParent($parents->parent_id)) {
					$data[$parents->title] = array('/catalog'.CatalogCategory::getCategoryRoute($parents->link));
				}

		}
		$data[$catalog_config->title] = array('/catalog');
		return array_reverse($data);
	}

    //****************************************************************************
	public static function getMenu($id=0) 
	{
		$subitems = array();

		foreach(CatalogCategory::model()->findAll('parent_id = ' . $id) as $model) {
			$subitems[] = array('label' => $model->title, 'url' => '/catalog/'.$model->link, 'active' => (strstr($_SERVER['REQUEST_URI'], '/'.$model->link)) ? true : false );
		}
		return $subitems;
	}

    //****************************************************************************
	public static function getCategoryRoute($link) {
        if($category=CatalogCategory::model()->find('link=:link', array('link'=>$link))){
            if($parent = CatalogCategory::model()->findByPk($category->parent_id)){
                $route=CatalogCategory::getCategoryRoute($parent->link)."/".$link;
            }else{$route="/".$link;}
          return $route;
        } else{
            return false;
        }

    }

    //****************************************************************************
    //возвращает максимальное значение поля сортировки
	public function getMaxSortOrder(){
		$models=CatalogCategory::model()->findAll();
		foreach($models as $model) {
			$sort_orders[]=$model->sort_order;
		}
        if(!empty($sort_orders)){
            arsort($sort_orders);
            $max_order=current($sort_orders);
        } else{$max_order=0;}

		return $max_order;
	}
	
	public function createUrl($route,$params=array(),$ampersand='&'){
        // если формируем ссылку на категорию
        if($route=='category'){
            if(isset($params['link'])){return '/catalog'.CatalogCategory::getCategoryRoute($params['link']);}
        }
	}
}