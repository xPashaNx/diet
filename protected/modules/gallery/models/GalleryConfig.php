<?php

/**
 * This is the model class for table "gallery_config".
 *
 * The followings are the available columns in table 'gallery_config':
 * @property integer $id
 * @property string $title
 * @property integer $limit
 * @property integer $display_mode
 * @property integer $selected_gallery_id
 * @property integer $prev_x
 * @property integer $prev_y
 */
class GalleryConfig extends CActiveRecord
{
	const FIRST_GALLERY = 0;
	const RANDOM_GALLERY = 1;
	const SELECTED_GALLERY = 2;
	
	public $arDisplayMode = array(
		self::FIRST_GALLERY => 'Первая галерея',
		self::RANDOM_GALLERY => 'Случайная галерея',
		self::SELECTED_GALLERY => 'Заданная галерея',
	);
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, display_mode, prev_x, prev_y', 'required'),
			array('prev_x, prev_y', 'numerical', 'integerOnly'=>true, 'min' => '1'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('limit, selected_gallery_id', 'safe'),
			array('id, title, limit, display_mode, selected_gallery_id, prev_x, prev_y', 'safe', 'on'=>'search'),
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
			'title' => 'Заголовок',
			'limit' => 'Количество галерей на странице в списке',
			'display_mode' => 'Режим отображения галерей в виджете для главной страницы',
			'selected_gallery_id' => 'Выбранная галерея для отображения',
			'prev_x' => 'Размеры фото превью (Ширина)',
			'prev_y' => 'Размеры фото превью (Высота)',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('limit',$this->limit);
		$criteria->compare('display_mode',$this->display_mode);
		$criteria->compare('selected_gallery_id',$this->selected_gallery_id);
		$criteria->compare('prev_x',$this->prev_x);
		$criteria->compare('prev_y',$this->prev_y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if ($this->display_mode != self::SELECTED_GALLERY)
			{
				$this->selected_gallery_id = null;
			}
            
			return true;
		}
		else
			return false;
	}
	
	public function getGalleryList()
	{
		$result = array();
		if ($galleries = Gallery::model()->findAll())
		{
			foreach ($galleries as $gallery)
			{
				$result[$gallery->id] = $gallery->title;
			}
		}
		
        return $result;
    }
}
