<?php

/**
 * This is the model class for table "catalog_category".
 *
 * The followings are the available columns in table 'catalog_category':
 * @property integer $id
 * @property integer $parent_id
 * @property string $short_title
 * @property string $long_title
 * @property string $link
 * @property string $keywords
 * @property string $description
 * @property string $image
 * @property string $text
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property CatalogService[] $catalogServices
 */
class CatalogCategory extends CActiveRecord
{
    /**
     * Folder for category images
     *
     * @var string
     */
    public $folder = 'upload/catalog/category';

	/**
	 * Returns the static model of the specified AR class
     *
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
	 * @return array validation rules for model attributes
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('short_title, long_title, link', 'required'),
			array('long_title, link', 'length', 'max' => 256),
			array('short_title', 'length', 'max' => 100),
			array('link','unique', 'message' => 'Категория со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('id, parent_id, short_title, long_title, link, keywords, description, image, text, sort_order', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, short_title, long_title, link, keywords, description, image, text, sort_order', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Behaviors
     *
     * @return array
     */
	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.modules.services.components.SSortable.SSortableCatalogBehavior',
                'categoryField' => 'parent_id',
			),
            //'CAdvancedArBehavior' => array('class' => 'application.extensions.EAdvancedArBehavior.EAdvancedArBehavior')
		);

	}     

	/**
	 * @return array relational rules
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catalogServices' => array(self::HAS_MANY, 'CatalogService', 'id_category','condition'=>'catalogServices.on_main=1', 'order'=>'sort_order'),
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
			'short_title' => 'Короткий заголовок',
			'long_title' => 'Длинный заголовок',
			'link' => 'Имя',
            'keywords' => 'Ключевые слова (метатег keywords)',
            'description' => 'Описание (метатег description)',
			'image' => 'Изображение',
            'text' => 'Описание категории',
            'sort_order' => 'Поле сортировки',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions
     *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		if (isset($_GET['id']))
			$this->parent_id = $_GET['id'];
		else
            $this->parent_id = 0;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('short_title',$this->short_title,true);
		$criteria->compare('long_title',$this->long_title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
			),
		));
	}

    /**
     * Before save
     *
     * @return bool
     */
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            $catalogСonfig = CatalogConfig::model()->findByPk(1);
            if (!$this->isNewRecord)
            {
               $old_model = CatalogCategory::model()->findByPk($this->id);
               $old_image = $old_model->image;
            }
            else
                $old_image = '';

			if ($image = CUploadedFile::getInstance($this, 'image'))
            {
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->image = $name;
				$image->saveAs($this->folder . '/' . $name);
				Yii::app()->ih
					->load($this->folder . '/' . $this->image)
                    ->resize($catalogСonfig->c_image_small_w, $catalogСonfig->c_image_small_h)
					->save($this->folder . '/small/' . $this->image, false, 100);
                if ($old_image)
                {
                    @unlink($this->folder . '/' .$old_image);
                    @unlink($this->folder . '/small/' .$old_image);
                }
			}
            else
                $this->image = $old_image;

			return true;
		}
		else
			return false;
	}

    /**
     * Get listed
     *
     * @param int $id
     *
     * @return array
     */
	public static function getListed($id = 0)
	{
		$subitems = array();
		$space = '';

		foreach (CatalogCategory::model()->findAll('parent_id = ' . $id) as $model)
        {
			$space .= ' ';
			$subitems[$model->id] = $space.$model->short_title;
			if ($items = CatalogCategory::getListed($model->id))
                foreach ($items as $key => $value)
                    $subitems[$key] = $value;
		}

		return $subitems;
	}

    /**
     * Get parents
     *
     * @param integer $id
     * @param bool $product
     *
     * @return array
     */
	public static function getParents($id, $service = false)
    {
		$data = array();
		if ($id != 0)
        {
			$parents = CatalogCategory::model()->findByPk($id);
            if ($service == true)
                $data[$parents->short_title] = array('/services/default/index', 'id'=>$parents->id);
            while ($parents = CatalogCategory::getParent($parents->parent_id))
                $data[$parents->short_title] = array('/services/default/index', 'id'=>$parents->id);
			$data['Каталог услуг'] = array('/services/default/index');
		}

		return array_reverse($data);
	}

    /**
     * Get childrens ids
     *
     * @return array
     */
    public function getAllChildIds()
    {
        $allchilds = array();

        $criteria = new CDbCriteria;
        $criteria->compare('parent_id', $this->id);
        $criteria->order = 'sort_order ASC';

        $thischilds = CatalogCategory::model()->findAll($criteria);
        foreach ($thischilds as $thischild){
            $allchilds[] = $thischild->id;
            $allchilds = array_merge($allchilds, $thischild->allChildIds);
        }

        return $allchilds;
    }

    /**
     * Get children category for select list
     *
     * @param int $spaced
     *
     * @return array
     */
    /*public function getAllChildsList($spaced = 0)
    {
        $allchilds = array();

        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', $this->id);
        $criteria->order = 'sort_order ASC';

        $thischilds = CatalogCategory::model()->findAll($criteria);
        foreach ($thischilds as $thischild)
        {
            $allchilds[$thischild->id] = str_repeat ('___', $spaced).$thischild->short_title;
            $allchilds = $allchilds + $thischild->getAllChildsList($spaced + 1);
        }

        return $allchilds;
    }*/

    /**
     * Get parent
     *
     * @param $id
     *
     * @return mixed
     */
	public static function getParent($id)
    {
		$parent = CatalogCategory::model()->findByPk($id);

		return $parent;
	}

    /**
     * Get breadcrumbs
     *
     * @param integer $id
     * @param bool $service
     *
     * @return array
     */
	public static function getBreadcrumbs($id, $service = true)
    {
        $catalogConfig = CatalogConfig::model()->findByPk(1);
		$data = array();
		if ($id != 0)
        {
			$parents = CatalogCategory::model()->findByPk($id);
            if ($service==true)
                $data[$parents->short_title] = array('/services'.CatalogCategory::getCategoryRoute($parents->link));
            while ($parents = CatalogCategory::getParent($parents->parent_id))
                $data[$parents->short_title] = array('/services'.CatalogCategory::getCategoryRoute($parents->link));
		}
		$data[$catalogConfig->title] = array('/service');

		return array_reverse($data);
	}

    /**
     * Get menu
     *
     * @param int $id
     *
     * @return array
     */
	public static function getMenu($id = 0)
	{
		$subitems = array();
		foreach (CatalogCategory::model()->findAll('parent_id = ' . $id) as $model)
			$subitems[] = array('label' => $model->short_title, 'url' => '/services/'.$model->link, 'active' => (strstr($_SERVER['REQUEST_URI'], '/'.$model->link)) ? true : false );

		return $subitems;
	}

    /**
     * Get category route
     *
     * @param $link
     *
     * @return bool|string
     */
	public static function getCategoryRoute($link)
    {
        if ($category = CatalogCategory::model()->find('link=:link', array('link' => $link)))
        {
            if ($parent = CatalogCategory::model()->findByPk($category->parent_id))
                $route = CatalogCategory::getCategoryRoute($parent->link)."/".$link;
            else
                $route = "/".$link;

            return $route;
        } else
            return false;
    }

    /**
     * Get max sort order
     *
     * @return int|mixed
     */
	public function getMaxSortOrder(){
		$models = CatalogCategory::model()->findAll();
		foreach ($models as $model)
			$sort_orders[] = $model->sort_order;
        if (!empty($sort_orders))
        {
            arsort($sort_orders);
            $max_order = current($sort_orders);
        }
        else
            $max_order = 0;

		return $max_order;
	}

    /**
     * Create url
     *
     * @param string $route
     * @param array  $params
     *
     * @return string
     */
	public function createUrl($route, $params=array())
    {
        if ($route == 'category')
            if(isset($params['link']))
                return '/services'.CatalogCategory::getCategoryRoute($params['link']);
	}
}