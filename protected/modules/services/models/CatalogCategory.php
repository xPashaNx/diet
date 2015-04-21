<?php

/**
 * This is the model class for table "catalog_category".
 *
 * The followings are the available columns in table 'catalog_category':
 * @property integer $id
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
			array('short_title, link', 'required'),
			array('long_title, link', 'length', 'max' => 255),
			array('short_title', 'length', 'max' => 100),
			array('link','unique', 'message' => 'Категория со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array(
                'image',
                'file',
                'types' => 'gif, jpg, jpeg, png',
                'allowEmpty' => true,
            ),
            array('id, short_title, long_title, link, keywords, description, image, text, sort_order', 'safe'),
			array('id, short_title, long_title, link, keywords, description, image, text, sort_order', 'safe', 'on'=>'search'),
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
				'class' => 'application.extensions.SSortable.SSortableBehavior',
			),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('short_title',$this->short_title,true);
		$criteria->compare('long_title',$this->long_title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 50,
			),
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
     * @return array
     */
	public static function getListed()
	{
		$subitems = array();
		$subitems[0] = '...';
		$space = '';

		foreach (CatalogCategory::model()->findAll() as $model)
        {
			$space .= ' ';
			$subitems[$model->id] = $space . $model->short_title;
		}

		return $subitems;
	}

    /**
     * Get parents
     *
     * @param integer $id
     * @param bool    $service
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
                $data[$parents->short_title] = array('/services/default/index', 'id' => $parents->id);
			$data['Управление услугами'] = array('/services/default/index');
		}
		else
		{
			if ($service == true)
				$data['Управление услугами'] = array('/services/default/index');
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
        $criteria->order = 'sort_order ASC';

        $thischilds = CatalogCategory::model()->findAll($criteria);
        foreach ($thischilds as $thischild)
        {
            $allchilds[] = $thischild->id;
            $allchilds = array_merge($allchilds, $thischild->allChildIds);
        }

        return $allchilds;
    }

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
            if ($service == true)
                $data[$parents->short_title] = array('/services'.CatalogCategory::getCategoryRoute($parents->link));
		}
		$data[$catalogConfig->title] = array('/services');

		return array_reverse($data);
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
	public function getMaxSortOrder()
    {
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