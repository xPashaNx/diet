<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $image
 * @property string $link
 * @property string $code
 * @property integer $content_type
 * @property integer $views
 * @property integer $clicks
 * @property integer $notactive
 */
class Banners extends CActiveRecord
{
	/**
	 * @const TYPE_IMAGE - Banner type image
	 * @const TYPE_CODE - Banner type code
	 */
	const TYPE_IMAGE = 1;
	const TYPE_CODE = 2;
	
	/**
	 * @var array banner content type
	 */
    public $content_type_list = array(
		self::TYPE_IMAGE => 'Картинка со ссылкой', 
		self::TYPE_CODE => 'Код'
	);

	/**
	 * @var string banner image upload folder
	 */
    public $folder = 'upload/banners';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banners the static model class
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
		return 'banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bannerarea, content_type, views, clicks, notactive', 'numerical', 'integerOnly'=>true),
			array('name, title, link', 'length', 'max'=>255),
            array('name, title', 'required'),
            array('name', 'unique', 'message' => 'Баннер с именем {value} уже существует!'),
            array('name', 'match', 'pattern' => '/^[A-Za-z0-9\-_]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('code', 'safe'),
			array('image', 'file', 'types' => 'gif, jpg, jpeg, png', 'allowEmpty' => true),
			array('id, name, title, image, link, code, content_type, views, clicks, notactive', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array behaviors
     */
	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
                'categoryField' => 'bannerarea',
			),
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
			'name' => 'Имя',
			'title' => 'Заголовок',
            'bannerarea' => 'Рекламное место',
			'image' => 'Картинка',
			'link' => 'Ссылка',
			'code' => 'Код баннера',
			'content_type' => 'Использовать картинку или код',
			'views' => 'Количество просмотров',
			'clicks' => 'Количество переходов',
			'notactive' => 'Не показывать',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('content_type',$this->content_type);
		$criteria->compare('views',$this->views);
		$criteria->compare('clicks',$this->clicks);
		$criteria->compare('notactive',$this->notactive);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

    /**
     * Increment banner view
     */
    public function incViews()
	{
        $this->views++;
        $this->save();
    }

    /**
     * Before save model
     * @return bool
     */
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            if (!$this->isNewRecord)
            {
               $old_model = Banners::model()->findByPk($this->id);
               $old_image = $old_model->image;
            }
			else
			{
                $old_image = '';
            }

			if ($image = CUploadedFile::getInstance($this, 'image'))
			{
				$name = md5(time().$image).'.'.$image->getExtensionName();
				$this->image = $name;
				$image->saveAs($this->folder . '/' . $name);

                if ($old_image)
				{
                    @unlink($this->folder . '/' .$old_image);
                }
			}
			else 
			{
				$this->image = $old_image;
			}

			return true;
		}
		else
			return false;
	}
}