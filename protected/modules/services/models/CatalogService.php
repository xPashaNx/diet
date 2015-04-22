<?php

/**
 * This is the model class for table "catalog_service".
 *
 * The followings are the available columns in table 'catalog_service':
 * @property integer $id
 * @property integer $id_category
 * @property string $short_title
 * @property string $long_title
 * @property string $link
 * @property string $keywords
 * @property string $description
 * @property string $photo
 * @property boolean $on_main
 * @property string $text
 * @property integer $sort_order
 *
 * The followings are the available model relations:
 * @property CatalogImage[] $catalogImages
 * @property CatalogCategory $idCategory
 */
class CatalogService extends CActiveRecord
{
    public $variation = NULL;
    public $images = NULL;

    /**
     * Folder for service images
     * @var string
     */
    public $folder = 'upload/catalog/service';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogService the static model class
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
		return 'catalog_service';
	}

    /**
     * @return array
     */
	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'id_category',
			),
		);

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('short_title, link', 'required'),
			array('sort_order', 'numerical', 'integerOnly' => true),
			array('short_title', 'length', 'max' => 100),
			array('long_title, link', 'length', 'max' => 255),
            array('link','unique', 'message' => 'Товар со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('id, id_category, short_title, long_title, link, keywords, description, photo, on_main, text, sort_order', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(
                'photo',
                'file',
                'types' => 'gif, jpg, jpeg, png',
                'allowEmpty' => true,
			),
			array('id, id_category, short_title, long_title, link, keywords, description, photo, on_main, text, sort_order', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'catalogImages' => array(self::HAS_MANY, 'CatalogImage', 'id_service', 'order'=>'sort_order'),
			'idCategory' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_category' => 'Категория',
			'short_title' => 'Короткое наименование',
			'long_title' => 'Длинное наименование',
            'link' => 'Ссылка',
            'keywords' => 'Ключевые слова (метатег keywords)',
            'description' => 'Описание (метатег description)',
			'photo' => 'Изображение',
            'on_main'=>'Опубликовать',
            'text' => 'Описание услуги',
            'sort_order' => 'Сортировка',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions
     *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('short_title',$this->short_title,true);
		$criteria->compare('long_title',$this->long_title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('on_main',$this->on_main,true);
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

    public function getEmptyServices()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id_category', 0,true);

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
            $catalogConfig = CatalogConfig::model()->findByPk(1);

            if (!$this->isNewRecord)
            {
               $old_model = CatalogService::model()->findByPk($this->id);
               $old_image = $old_model->photo;
            }
            else
                $old_image = '';

			if	($photo = CUploadedFile::getInstance($this, 'photo'))
            {
				$name = md5(time().$photo).'.'.$photo->getExtensionName();
				$this->photo = $name;
				$photo->saveAs($this->folder . '/' . $name);
                if ($catalogConfig->watermark_image && !$catalogConfig->no_watermark)
                {
                    Yii::app()->ih
                        ->load($this->folder . '/' . $this->photo)
                        ->watermark($this->folder . '/watermark/'.$catalogConfig->watermark_image , $catalogConfig->watermark_x, $catalogConfig->watermark_y)
                        ->save();
                }

                switch ($catalogConfig->resize_mode)
                {
                    case 2:
                        Yii::app()->ih
                            ->load($this->folder . '/' . $this->photo)
                            ->resizeCanvas($catalogConfig->s_image_middle_w, $catalogConfig->s_image_middle_h)
                            ->save($this->folder . '/medium/' . $this->photo)
                            ->reload()
                            ->resizeCanvas($catalogConfig->s_image_small_w, $catalogConfig->s_image_small_h)
                            ->save($this->folder . '/small/' . $this->photo);
                        break;
                    
                    default:
                        Yii::app()->ih
                            ->load($this->folder . '/' . $this->photo)
                            ->resize($catalogConfig->s_image_middle_w, $catalogConfig->s_image_middle_h)
                            ->save($this->folder . '/medium/' . $this->photo)
                            ->reload()
                            ->resize($catalogConfig->s_image_small_w, $catalogConfig->s_image_small_h)
                            ->save($this->folder . '/small/' . $this->photo);
                        break;
                }

                if ($old_image)
                {
                    @unlink($this->folder . '/' .$old_image);
                    @unlink($this->folder . '/medium/' .$old_image);
                    @unlink($this->folder . '/small/' .$old_image);
                }
			}
            else
                $this->photo = $old_image;

            $serviceImages = new CatalogImage;

			if ($serviceImagesUpload = CUploadedFile::getInstances($serviceImages, 'image'))
            {
				foreach ($serviceImagesUpload as $file)
                {
                    $serviceImages = new CatalogImage;
                    $serviceImagesName = md5(time().$file->name).'.'.$file->getExtensionName();
                    $serviceImages->image = $serviceImagesName;

                    $file->saveAs($this->folder . '/moreimages/' . $serviceImagesName);
                    $this->images[] = $serviceImages;
                    if ($catalogConfig->watermark_image && !$catalogConfig->no_watermark)
                    {
                        Yii::app()->ih
                            ->load($this->folder . '/moreimages/' . $serviceImagesName)
                            ->watermark($this->folder . '/watermark/'.$catalogConfig->watermark_image , $catalogConfig->watermark_x, $catalogConfig->watermark_y)
                            ->save();
                    }

                    switch($catalogConfig->resize_mode)
                    {
                        case 2:
                            Yii::app()->ih
                                ->load($this->folder . '/moreimages/' . $serviceImagesName)
                                ->resizeCanvas($catalogConfig->s_image_small_w, $catalogConfig->s_image_small_h)
                                ->save($this->folder . '/moreimages/small/' . $serviceImagesName)
                                ->reload()
                                ->resizeCanvas($catalogConfig->s_image_middle_w, $catalogConfig->s_image_middle_h)
                                ->save($this->folder . '/moreimages/medium/' .$serviceImagesName);
                            break;

                        default:
                            Yii::app()->ih
                                ->load($this->folder . '/moreimages/' . $serviceImagesName)
                                ->resize($catalogConfig->s_image_small_w, $catalogConfig->s_image_small_h)
                                ->save($this->folder . '/moreimages/small/' . $serviceImagesName)
                                ->reload()
                                ->resize($catalogConfig->s_image_middle_w, $catalogConfig->s_image_middle_h)
                                ->save($this->folder . '/moreimages/medium/' .$serviceImagesName);
                            break;
                    }

				}
			}

			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked before the record is saved
     *
	 * @return boolean whether the record should be saved
	 */
    protected function afterSave()
    {
        parent::afterSave();

		if (!empty($this->images))
			foreach($this->images as $image)
            {
				$image->id_service = $this->id;
				$image->save();
			}
    }

    /**
     * Remove the related model
     *
     * @return bool
     */
    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
			foreach ($this->catalogImages as $image)
            {
				@unlink ($this->folder . '/moreimages/' . $image->image);
				@unlink ($this->folder . '/moreimages/medium/' . $image->image);
				@unlink ($this->folder . '/moreimages/small/'  . $image->image);
                $image->delete();
			}

            @unlink ($this->folder . '/' . $this->photo);
            @unlink ($this->folder . '/medium/' . $this->photo);
            @unlink ($this->folder . '/small/' . $this->photo);

            return true;
        }
        else
            return false;
    }

    /**
     * Get max sort order
     *
     * @return int|mixed
     */
	public function getMaxSortOrder()
    {
		$models = self::model()->findAll();
		foreach ($models as $model)
			$sort_orders[]=$model->sort_order;
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
     * Returns the full link to the service
     *
     * @return string
     */
    public function getFullLink()
    {
        if (isset($this->idCategory))
            return '/services'.CatalogCategory::getCategoryRoute($this->idCategory->link).'/'.$this->link.'.html';
        else
            return '/services/'.$this->link.'.html';
    }
}