<?php

/**
 * This is the model class for table "bannerarea".
 *
 * The followings are the available columns in table 'bannerarea':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $mode
 * @property string $queue
 * @property string $widget
 */
class Bannerarea extends CActiveRecord
{
    /**
     * @const SHOW_ALL - Show all banners
     * @const ONE_AT_ROTATION - Show one banner at rotation
     * @const RANDOM_ROTATION - Show one random banner at rotation
     * @const RANDOM_ALL - Show all random banners
     * @const SLIDER - Show banners in slider
     */
	const SHOW_ALL = 1;
	const ONE_AT_ROTATION = 2;
	const RANDOM_ROTATION = 3;
	const RANDOM_ALL = 4;
	const SLIDER = 5;

    /**
     * @var array - Banner modes
     */
    public $modes = array(
		self::SHOW_ALL => 'Показывать все', 
		self::ONE_AT_ROTATION => 'Поочередная ротация', 
		self::RANDOM_ROTATION => 'Случайная ротация', 
		self::RANDOM_ALL => 'Показывать все в случайном порядке',
		self::SLIDER => 'Слайдер'
	);
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bannerarea the static model class
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
		return 'banner_area';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('mode', 'numerical', 'integerOnly'=>true),
			array('name, title, widget', 'length', 'max'=>255),
            array('name, title', 'required'),
            array('name', 'unique', 'message' => 'Рекламное место с именем {value} уже существует!'),
            array('name', 'match',  'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
            array('widget', 'match', 'pattern' => '/^[A-Za-z0-9]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры!'),

			array('id, name, title, mode, queue, widget', 'safe', 'on'=>'search'),
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
            'banners'=>array(self::HAS_MANY, 'Banners', 'bannerarea'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя',
			'title' => 'Название',
            'mode' => 'Режим отображения',
			'queue' => 'Очередь',
			'widget' => 'Виджет для отображения',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('mode',$this->mode,true);
		$criteria->compare('queue',$this->queue,true);
		$criteria->compare('widget',$this->widget,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return array - List of banner areas
     */
	public static function createAreaList()
	{
		$areaList = array();
		if ($bannerAreas = Bannerarea::model()->findAll())
		{
			foreach ($bannerAreas as $bannerArea)
			{
				$areaList[$bannerArea['id']] = $bannerArea['title'];
			}
		}
		
		return $areaList;
	}
}