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

    public $arFilter = array(
        0 => 'Не опубликован',
        1 => 'Опубликован',
    );

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
		return array(
			array('name, email, text', 'required'),
			array('name', 'length', 'max' => 100),
			array('text', 'length', 'max' => 1000),
            array('email', 'email'),
            array('name, email, text', 'validateHtmlTag'),
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

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('public',$this->public,true);
		$criteria->compare('checked',$this->checked,true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'date_create DESC',
            ),
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
     * Get checked reviews
     *
     * @return mixed
     */
    public static function getCheckedReviews()
    {
        return self::model()->findAllByAttributes(array('checked' => true));
    }

    /**
     * Custom validator
     *
     * @param string $attribute
     */
    public function validateHtmlTag($attribute)
    {
        if ((strpos($this->$attribute, 'http://') !== false) or (strpos($this->$attribute, 'https://') !== false))
            $this->addError($attribute, 'Строка не должна содержать "http://" или "https://"');
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
            $this->name = strip_tags($this->name);
            $this->email = strip_tags($this->email);
            $this->text = strip_tags($this->text);
            return true;
        }
        else
            return false;
    }
}
