<?php

/**
 * This is the model class for table "gallery".
 *
 * The followings are the available columns in table 'gallery':
 * @property integer $id
 * @property string $title
 * @property integer $cover_photo_id
 * @property integer $sort_order
 */
class Gallery extends CActiveRecord
{
	public $uploaded_photos = NULL;
    public $folder = 'upload/gallery';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery';
	}
	
	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.extensions.SSortable.SSortableBehavior',
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
			array('cover_photo_id, sort_order', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, cover_photo_id, sort_order', 'safe', 'on'=>'search'),
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
			'photos' => array(self::HAS_MANY, 'GalleryPhoto', 'gallery_id'),
			'cover' => array(self::BELONGS_TO, 'GalleryPhoto', 'cover_photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название галереи',
			'cover_photo_id' => 'Картинка-обложка галереи',
			'sort_order' => 'Sort Order',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('cover_photo_id',$this->cover_photo_id);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// Возвращает обложку галереи в виде объекта
    // Если обложка не найдена - возвращает false
    public function getCover()
	{
        // Если в галерее есть фото
        if (isset($this->photos))
		{
            // Если указана обложка - возвращаем ее
            if ($this->cover_photo_id)
			{
                $coverPhoto = GalleryPhoto::model()->findByPk($this->cover_photo_id);
                if ($coverPhoto)
				{
                    $result = $coverPhoto;
                }
				else
				{
                    $result = false;
                }
            }
			else
			{
                // Если не указана обложка - берем первую фотку
                $criteria = new CDbCriteria;
                $criteria->order = 'sort_order';
                $criteria->condition = 'gallery_id=:gallery_id';
                $criteria->params = array(':gallery_id' => $this->id);
                $coverPhoto = GalleryPhoto::model()->find($criteria);
                $result = $coverPhoto;
            }
        }
		else
		{
            $result = false;
        }
		
		return $result;
    }

    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			// Читаем конфигурацию каталога
            $galleryConfig = GalleryConfig::model()->findByPk(1);

            // Загружаем фотографии
            $photos = new GalleryPhoto;

			if ($photosUpload = CUploadedFile::getInstances($photos, 'image'))
			{
				foreach ($photosUpload as $file)
				{
					$photo = new GalleryPhoto;
					$photoName = md5(time().$file->name).'.'.$file->getExtensionName();
					$photo->file = $photoName;
					$file->saveAs($this->folder . '/' . $photoName);
					$this->uploaded_photos[] = $photo;

                    Yii::app()->ih
                        ->load($this->folder . '/' . $photoName)
						->adaptiveThumb($galleryConfig->prev_x,$galleryConfig->prev_y)
						//->resize($galleryConfig->prev_x,$galleryConfig->prev_y)
                        //->adaptiveThumb(160, 105)//144 94
                        ->save($this->folder . '/small/' . $photoName, false, 100)
						->reload()
						->resize(200,135)
						//->adaptiveThumb(200, 135)
						->save($this->folder . '/medium/' . $photoName, false, 100);
				}
			}

			if ($this->isNewRecord)
			{
				$this->sort_order = $this->getMaxSortOrder() + 10;
			}
		
			if (!empty($this->uploaded_photos)) 
			{
				foreach($this->uploaded_photos as $photo)
				{
					$photo->gallery_id = $this->id;
					$photo->save();
				}

				if ($this->photos and $coverPhoto = $this->getCover())
				{
					$this->cover_photo_id = $coverPhoto->id;
				}
			}
			
			return true;
		}
		else
			return false;
	}

    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем все фотографии
			foreach ($this->photos as $photo) {
				@unlink ($this->folder . '/' . $photo->file);
				@unlink ($this->folder . '/small/'  . $photo->file);
				@unlink ($this->folder . '/medium/'  . $photo->file);

                $photo->delete();
			}

            return true;
        }
        else
            return false;
    }
	
	//возвращает максимальное значение поля сортировки
	public function getMaxSortOrder()
	{
		$models = Gallery::model()->findAll();
		foreach ($models as $model) 
		{
			$sort_orders[] = $model->sort_order;
		}
        if (!empty($sort_orders))
		{
            arsort($sort_orders);
            $max_order = current($sort_orders);
        }
		else
		{
			$max_order = 0;
		}

		return $max_order;
	}
	
	public function getMinSortOrder()
	{
		$models = Gallery::model()->findAll();
		foreach ($models as $model) 
		{
			$sort_orders[] = $model->sort_order;
		}
        if (!empty($sort_orders))
		{
            asort($sort_orders);
            $min_order = current($sort_orders);
        }
		else
		{
			$min_order = 0;
		}

		return $min_order;
	}
	
	public static function getFirstGallery()
	{
        return Gallery::model()->findByAttributes(array('sort_order' => self::getMinSortOrder()));
    }
	
	public static function getRandomGallery()
	{
        $criteria = new CDbCriteria;
        $criteria->select = "*, rand() as rand";
        $criteria->order = "rand";
        return Gallery::model()->find($criteria);
    }
	
	public static function getSelectedGallery($id)
	{
        return Gallery::model()->findByPk($id);
    }
}
