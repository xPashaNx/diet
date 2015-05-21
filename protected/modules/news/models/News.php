<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property string $date
 * @property string $annotation
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $public
 * @property integer $cover_id
 */
class News extends CActiveRecord
{
    //папка для загрузки картинок
    const FOLDER_UPLOAD = 'upload/userfiles/images/';

    public $uploaded_images = array();

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, link', 'unique'),
            array('title, link, annotation, description, meta_keywords, meta_description, public, cover_id', 'required'),
            array('link', 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => 'В поле "Имя" можно вводить только латинские буквы и тире.'),
            array('public, cover_id', 'numerical', 'integerOnly' => true),
            array('title, link, annotation', 'length', 'max' => 255),
            array('date', 'default', 'value' => date("Y-m-d H:i:s")),
            array('id, title, link, date, annotation, description, meta_keywords, meta_description, public, cover_id', 'safe', 'on' => 'search'),
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
            'newsImages' => array(self::HAS_MANY, 'NewsImages', 'news_id'),
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
            'link' => 'Имя',
            'date' => 'Дата создания',
            'annotation' => 'Аннотация ',
            'description' => 'Текст новости',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'public' => 'Публиковать?',
            'cover_id' => 'Cover',
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
    public function search($dateCriteria = NULL)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('annotation', $this->annotation, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('public', $this->public);
        $criteria->compare('cover_id', $this->cover_id);

        if ($dateCriteria) {
            $criteria->mergeWith($dateCriteria);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'attributes'=>array(
                    'id' ,
                    'title',
                    'date'
                )
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        if (!parent::beforeSave())
            return false;

        $this->title = ucfirst($this->title);
        $this->annotation = ucfirst($this->annotation);

        // Сохранение катинок
        $images = new NewsImages();


        if ($imagesUpload = CUploadedFile::getInstances($images, 'filename')
        ) {
			//проверка существования пити, если нет создать
			if(!file_exists(self::FOLDER_UPLOAD))
				mkdir(self::FOLDER_UPLOAD, 0777, true);
			
            foreach ($imagesUpload as $file) {
                $image = new NewsImages();
                $imageName = md5(time().$file->name) . '.' . $file->getExtensionName();
                $image->filename = $imageName;
                $file->saveAs(self::FOLDER_UPLOAD . '/' . $imageName);
                $this->uploaded_images[] = $image;
            }
        }
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        parent::afterSave();

        if (!empty($this->uploaded_images)) {
            foreach ($this->uploaded_images as $image) {
                $image->news_id = $this->id;
                $image->save();
            }

            // записываем в cover_id первую картинку в качестве обложки
            $imageOne = $this->uploaded_images[0];
            self::model()->updateByPk($this->id, array('cover_id' => $imageOne->id));
        }
    }

    protected function beforeDelete()
    {
        if (!parent::beforeDelete())
            return false;

        foreach ($this->newsImages as $image) {
            @unlink(self::FOLDER_UPLOAD . '/' . $image->filename);
            $image->delete();
        }

        return parent::beforeDelete();
    }
}
