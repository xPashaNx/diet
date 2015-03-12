<?php

/**
 * This is the model class for table "catalog_image".
 *
 * The followings are the available columns in table 'catalog_image':
 * @property string $id
 * @property string $id_service
 * @property string $image
 * @property string $alt_text
 * @property string $sort_order
 *
 * The followings are the available model relations:
 * @property CatalogService $idService
 */
class CatalogImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class
     *
	 * @return CatalogImage the static model class
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
		return 'catalog_image';
	}

	/**
	 * @return array validation rules for model attributes
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_service, image', 'required'),
			array('id_service', 'length', 'max' => 11),
			array('image, alt_text', 'length', 'max' => 256),
            array('image', 'validateImage'),
            /*array(
                'image',
                'file',
                'types' => 'gif, jpg, jpeg, png',
                'allowEmpty' => true,
            ),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_service, image, alt_text', 'safe'),
			array('id, id_service, image, alt_text', 'safe', 'on'=>'search'),
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
			'idService' => array(self::BELONGS_TO, 'CatalogService', 'id_service'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_service' => 'Id Service',
			'image' => 'Image',
			'alt_text' => 'Alt Text',
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

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_service',$this->id_product,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('alt_text',$this->alt_text,true);
		$criteria->compare('sort_order',$this->sort_order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Custom validator
     *
     * @param string $attribute
     */
    public function validateImage($attribute)
    {
        if ($attribute == 'image')
            if (!strpos($this->$attribute, 'jpeg') and !strpos($this->$attribute, 'jpg') and !strpos($this->$attribute, 'png') and !strpos($this->$attribute, 'gif'))
                $this->addError($attribute, 'Неправильный тип файла');
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
            if ($this->isNewRecord)
                $this->sort_order = $this->getMaxSortOrder() + 10;

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
}