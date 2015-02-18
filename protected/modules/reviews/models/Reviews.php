<?php

/**
 * This is the model class for table "reviews".
 *
 * The followings are the available columns in table 'reviews':
 * @property integer $id
 * @property string $date_create
 * @property string $name
 * @property string $email
 * @property string $text
 * @property integer $public
 * @property integer $checked
 */
class Reviews extends CActiveRecord
{
    /**
     * @var captcha check result
     */
    public $verifyCode;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, text', 'required'),
			array('name', 'length', 'max' => 100),
			array('text', 'length', 'max' => 1000),
            array('email', 'email'),
            array('verifyCode', 'captcha', 'on' => 'captcha'),
			array('date_create, name, text, public, checked', 'safe'),
			array('id, date_create, name, email, text, public, checked', 'safe', 'on' => 'search'),
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
			'date_create' => 'Дата создания',
			'name' => 'Имя',
			'email' => 'Email',
			'text' => 'Текст',
			'public' => 'Опубликовать',
			'checked' => 'Отмеченный',
            'verifyCode' => 'Код проверки',
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
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('public',$this->public,true);
		$criteria->compare('checked',$this->checked,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reviews the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
            $this->date_create = date('Y-m-d H:i:s');
            return true;
        }
        else
            return false;
    }

    public static function getCheckedReviews()
    {
        return self::model()->findAllByAttributes(array('checked' => true));
    }
}
