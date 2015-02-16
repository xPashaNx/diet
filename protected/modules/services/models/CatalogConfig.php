<?php

/**
 * This is the model class for table "catalog_config".
 *
 * The followings are the available columns in table 'catalog_config':
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $layout
 * @property integer $category_perpage
 * @property integer $service_perpage
 * @property integer $c_image_small_w
 * @property integer $c_image_small_h
 * @property integer $s_image_middle_w
 * @property integer $s_image_middle_h
 * @property integer $s_image_small_w
 * @property integer $s_image_small_h
 * @property integer $resize_mode
 * @property string $watermark_image
 * @property integer $watermark_x
 * @property integer $watermark_y
 * @property boolean $no_watermark
 * @property string $text
 */
class CatalogConfig extends CActiveRecord
{
    /**
     * @var string folder for service images
     */
    public $serviceImagesFolder = 'upload/catalog/service';

    public $arResizeModes = array(
        0 => 'Пропорционально вписать в заданный размер',
        1 => 'Пропорционально вписать в заданный размер и дополнить белым полем',
    );

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogConfig the static model class
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
		return 'catalog_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, layout', 'length', 'max'=>255),
            array('title, c_image_small_w, c_image_small_h, s_image_middle_w, s_image_middle_h, s_image_small_w, s_image_small_h, resize_mode', 'required'),
            array('category_perpage, service_perpage', 'numerical', 'integerOnly' => true),
            array('c_image_small_w, c_image_small_h, s_image_middle_w, s_image_middle_h, s_image_small_w, s_image_small_h, watermark_x, watermark_y', 'numerical', 'min' => 1, 'integerOnly' => true),
			array(
                'watermark_image',
                'file',
                'types' => 'png',
                'allowEmpty' => true,
			),
            // todo сделать для category_perpage и service_perpage сообщение на нормальном русском языке
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('id, title, keywords, description, layout, category_perpage, service_perpage, c_image_small_w, c_image_small_h, s_image_middle_w, s_image_middle_h, s_image_small_w, s_image_small_h, resize_mode, watermark_image, watermark_x, watermark_y, no_watermark, text', 'safe'),
			array('id, title, keywords, description, layout, category_perpage, service_perpage, c_image_small_w, c_image_small_h, s_image_middle_w, s_image_middle_h, s_image_small_w, s_image_small_h, resize_mode, watermark_image, watermark_x, watermark_y, no_watermark, text', 'safe', 'on' => 'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'keywords' => 'Ключевые слова (метатег keywords)',
			'description' => 'Описание (метатег description)',
            'layout' => 'Шаблон первой страницы',
            'category_perpage' => 'Категорий на странице',
            'service_perpage' => 'Услуг на странице',
            'c_image_small_w' => 'Ширина превью',
            'c_image_small_h' => 'Высота превью',
            's_image_middle_w' => 'Ширина среднего превью',
            's_image_middle_h' => 'Высота среднего превью',
            's_image_small_w' => 'Ширина малого превью',
            's_image_small_h' => 'Высота малого превью',
            'resize_mode' => 'Способ уменьшения изображений',
            'watermark_image' => 'Картинка водяного знака',
            'no_watermark' => 'Не накладывать водяной знак',
            'watermark_x' => 'Отступ по горизонтали',
            'watermark_y' => 'Отступ по вертикали',
            'text' => 'Текстовое описание каталога',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('category_perpage',$this->category_perpage,true);
		$criteria->compare('service_perpage',$this->service_perpage,true);
		$criteria->compare('c_image_small_w',$this->c_image_small_w,true);
		$criteria->compare('c_image_small_h',$this->c_image_small_h,true);
		$criteria->compare('s_image_middle_w',$this->s_image_middle_w,true);
		$criteria->compare('s_image_middle_h',$this->s_image_middle_h,true);
		$criteria->compare('s_image_small_w',$this->s_image_small_w,true);
		$criteria->compare('s_image_small_h',$this->s_image_small_h,true);
		$criteria->compare('resize_mode',$this->resize_mode,true);
		$criteria->compare('watermark_image',$this->watermark_image,true);
		$criteria->compare('no_watermark',$this->no_watermark,true);
		$criteria->compare('watermark_x',$this->watermark_x,true);
		$criteria->compare('watermark_y',$this->watermark_y,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

    protected function beforeSave()
	{
        $catalog_config = CatalogConfig::model()->findByPk($this->id);
        $old_image = $catalog_config->watermark_image;
		if(parent::beforeSave())
        {
			if ($image = CUploadedFile::getInstance($this, 'watermark_image')){
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->watermark_image = $name;
				$image->saveAs($this->serviceImagesFolder . '/watermark/' . $name);
                @unlink($this->serviceImagesFolder . '/watermark/' . $old_image);
			}
            else
            {
                $this->watermark_image = $old_image;
            }
            return true;
		}
		else
			return false;
	}
}