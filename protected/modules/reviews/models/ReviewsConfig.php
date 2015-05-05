<?php

/**
 * This is the model class for table "reviews_config".
 *
 * The followings are the available columns in table 'reviews_config':
 * @property integer $id
 * @property integer $premoder
 * @property integer $reviews_perpage
 * @property integer $show_captcha
 */
class ReviewsConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reviews_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('premoder, reviews_perpage, show_captcha', 'numerical', 'integerOnly'=>true),
			array('id, premoder, reviews_perpage, show_captcha', 'safe', 'on'=>'search'),
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
			'premoder' => 'Премодерация',
			'reviews_perpage' => 'Количество отзывов на странице',
			'show_captcha' => 'Использование "капчи"',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('premoder',$this->premoder);
		$criteria->compare('reviews_perpage',$this->reviews_perpage);
		$criteria->compare('show_captcha',$this->show_captcha);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReviewsConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
