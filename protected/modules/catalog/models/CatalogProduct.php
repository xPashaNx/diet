<?php

/**
 * This is the model class for table "catalog_product".
 *
 * The followings are the available columns in table 'catalog_product':
 * @property string $id
 * @property string $photo
 * @property string $description
 * @property string $id_category
 * @property integer $sort_order
 * @property integer $date_added
 * @property integer $on_main
 *
 * The followings are the available model relations:
 * @property CatalogImage[] $catalogImages
 * @property CatalogCategory $idCategory
 */
class CatalogProduct extends CActiveRecord
{
    public $variation = NULL;
    public $images = NULL;
    // Фолдер для картинок
    public $folder='upload/catalog/product';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return CatalogProduct the static model class
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
		return 'catalog_product';
	}

	public function behaviors()
	{
		return array(
			'SSortableBehavior' => array(
				'class' => 'application.modules.catalog.components.SSortable.SSortableCatalogBehavior',
                'categoryField' => 'id_category',
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
			array('title, link','required'),
			array('sort_order, views', 'numerical', 'integerOnly'=>true),
            array('price', 'numerical', 'min'=>0),
			array('photo, title, article, link', 'length', 'max'=>256),
			array('id_category', 'length', 'max'=>11),
            array('link','unique', 'message' => 'Товар со ссылкой {value} уже существует!'),
            array('link', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/u', 'message' => 'Поле {attribute} должно содержать только латинские буквы, цифры и знак "-"!'),
			array('long_title, keywords, description, descr_tag, sort_order, on_main, hit, recomended', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(
							'photo',
							'file',
							'types' => 'gif, jpg, jpeg, png',
							'allowEmpty' => true,
			),
			array('id, photo, description, id_category, sort_order, on_main', 'safe', 'on'=>'search'),
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

            // Картинки товара
			'catalogImages' => array(self::HAS_MANY, 'CatalogImage', 'id_product'),

            // Категория товара
			'idCategory' => array(self::BELONGS_TO, 'CatalogCategory', 'id_category'),

            // Атрибуты товара
			'productAttrubute' => array(self::HAS_MANY, 'CatalogProductAttribute', 'id_product'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Наименование',
			'long_title' => 'Длинное наименование',
            'link' => 'Ссылка',
            'keywords' => 'Ключевые слова',
            'descr_tag'=>'Описание (тег description)',
			'photo' => 'Фотография',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'currency' => 'Валюта',
            'priceprofile' => 'Ценовой профиль',
			'description' => 'Описание товара',
			'id_category' => 'Категория',
			'sort_order' => 'Сортировка',
			'date_added' => 'Дата добавления',
            'article'=>'Артикул',
            'on_main'=>'Опубликовать',
            'recomended'=>'Рекомендуемый',
            'hit'=>'Хит продаж',
            'views'=>'Количество просмотров',
            'brand'=>'Бренд',
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
		/*if(isset($_GET['id']))
			$this->id_category=$_GET['id'];
		else $this->id_category=0;*/

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('id_category',$this->id_category);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('date_added',$this->date_added);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50,
				),
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));
	}

    //**********************************************************************
    // записывает атрибуты товара в базу данных
    public function productAttributeSave($postProductAttributes){

                // преобразуем полученный массив с целью преобразовать элементы с множественными значениями
                // в формат, удобный для разбора
                foreach($postProductAttributes as $id_attrib=>$postProductAttribute){
                    foreach($postProductAttribute as $field=>$attr_values){
                        foreach($attr_values as $key=>$attr_value){
                            $newPostProductAttributes[$id_attrib][$key][$field]=$attr_value;
                        }
                    }

                }

                // выбираем все существующие типы атрибутов
                //$existingAttributes=CatalogAttribute::model()->findAll();
                $existingAttributes=$this->idCategory->use_attribute;

                foreach($existingAttributes as $existingAttribute){
                    // если в пост-запросе не существует данного типа атрибута
                    if (!isset($newPostProductAttributes[$existingAttribute->id])){
                        // создаем его и обнуляем
                        $newPostProductAttributes[$existingAttribute->id][0]['value']=0;
                    }

                    //выбираем все значения данного аттрибута для данного товара
                    $attr_values=CatalogProductAttribute::model()->findAll(
                              'id_attribute=:id_attribute AND id_product=:id_product',
                              array('id_attribute'=>$existingAttribute->id, 'id_product'=>$this->id)
                    );

                    //устанавливаем на начало указатель массива значений атрибута
                    reset($newPostProductAttributes[$existingAttribute->id]);

                    // если значения для данного атрибута существуют

                    foreach($attr_values as $attr_value){

                        // если значения еще не кончились - записываем
                        if($current_value=each($newPostProductAttributes[$existingAttribute->id])){
                            $attr_value->attributes=$current_value['value'];
                            $attr_value->save();
                        } else{
                            // если больше нечего записывать - удаляем лишние значения из базы
                            $attr_value->delete();
                        }

                    }

                    // если все еще остались незаписанные значения - записываем
                    while($current_value=each($newPostProductAttributes[$existingAttribute->id])){
                        $attr=new CatalogProductAttribute;
                        $attr->attributes=$current_value['value'];
                        $attr->id_product=$this->id;
                        $attr->id_attribute=$existingAttribute->id;
                        $attr->save();
                    }




                }
    }
	
	public function getProductAttributes(){
		$attribute=array();
		foreach($this->productAttrubute as $attr){
			$attribute[$attr->id_attribute]=$attr;
		}
		return $attribute;
	}

    // Получить значение атрибута товара с заданным именем
    // Возвращает значение атрибута. Для типа "Список" возвращает id значения
    // Для типа "Множественный выбор" возвращает массив из id значений
    // если значение не установлено - возвращает false
    public function getProductAttributeValue($attribute_name){
        if($attr=CatalogAttribute::model()->find('name=:name', array('name'=>$attribute_name))){
            // Перебираем все значения атрибутов данного товара
            foreach($this->productAttrubute as $attribute_value){
                // Если находим значения требуемого атрибута - запоминаем в массив
                if($attribute_value->id_attribute==$attr->id){
                    $all_values[]=$attribute_value->value;
                }
            }

            // Если найдено хотя бы одно значение - возвращаем
            if(isset($all_values)){
                // Если массив состоит только из одного элемента - возвращаем только его
                if(count($all_values)==1){
                    return $all_values[0];
                }else{
                    //...иначе возвращаем весь массив
                    return $all_values;
                }

            }else{
               return false;
            }


        }else{
            return false;
        }

    }

    //**********************************************************************
    // Отдает значения атрибутов товара пригодными для вывода. Массивом вида
    // $outAttrs[$name]['title'] - Название атрибута $outAttrs[$name]['value'] - Значение атрибута
    // где $name - имя атрибута
    public function outAttrs(){
        $outAttrs=array();
        foreach($this->productAttrubute as $attribute){
            $outAttrs[$attribute->idAttribute->name]['title']=$attribute->idAttribute->title;

            switch($attribute->idAttribute->id_attribute_kind){
                case 3:
                    // Если значение типа Список - берем соответствующее значение
                    $outAttrs[$attribute->idAttribute->name]['value']=$attribute->trueValue['value'];
                    break;
                case 4:
                    // Если значение типа - множественный выбор, то ячейка value возвращается массивом
                    $outAttrs[$attribute->idAttribute->name]['value'][]=$attribute->trueValue['value'];
                    break;
                case 5:
                    // Если значение типа Флаг - преобразуем в "Да" и "Нет"
                    if($attribute->value){
                        $outAttrs[$attribute->idAttribute->name]['value']='Да';
                    }else{$outAttrs[$attribute->idAttribute->name]['value']='Нет';}
                    break;
                default:
                    $outAttrs[$attribute->idAttribute->name]['value']=$attribute->value;
                    break;
            }
            // Если значение типа Список или Множественный выбор - берем соответствующее значение
            /*if($attribute->idAttribute->id_attribute_kind==3 || $attribute->idAttribute->id_attribute_kind==4){
                $outAttrs[$attribute->idAttribute->name]['value']=$attribute->trueValue['value'];
            }else{

                // Если значение типа Флаг - преобразуем в "Да" и "Нет"
                if($attribute->idAttribute->id_attribute_kind==5){
                    if($attribute->value){
                        $outAttrs[$attribute->idAttribute->name]['value']='Да';
                    }else{$outAttrs[$attribute->idAttribute->name]['value']='Нет';}

                }else{$outAttrs[$attribute->idAttribute->name]['value']=$attribute->value;}
            }*/

        }
        return $outAttrs;
    }

    //**********************************************************************
    protected function beforeSave()
	{
		if(parent::beforeSave())
		{
            // Читаем конфигурацию каталога
            $catalog_config=CatalogConfig::model()->findByPk(1);

            //Перед записью загружаем картинки

            // Если это не новая запись - Берем старую модель для удаления старой картинки
            if(!$this->isNewRecord)
            {
               $old_model=CatalogProduct::model()->findByPk($this->id);
               $old_image=$old_model->photo;
            }else{
                $old_image='';
                // тут же записываем дату создания
                $this->date_added=time();
            }

			if	($photo = CUploadedFile::getInstance($this, 'photo')){
				$name = md5(time().$photo).'.'.$photo->getExtensionName();
				$this->photo = $name;
				$photo->saveAs($this->folder . '/' . $name);
                if(isset($catalog_config->watermark_image) && !$catalog_config->no_watermark){
                    Yii::app()->ih
                        ->load($this->folder . '/' . $this->photo)
                        ->watermark($this->folder . '/watermark/'.$catalog_config->watermark_image , $catalog_config->watermark_x, $catalog_config->watermark_y)
                        ->save();
                }

                // Способы изменения размера
                switch($catalog_config->resize_mode){
                    case 2:
                        Yii::app()->ih
                            ->load($this->folder . '/' . $this->photo)
                            ->resizeCanvas($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
                            ->save($this->folder . '/medium/' . $this->photo)
                            ->reload()
                            ->resizeCanvas($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
                            ->save($this->folder . '/small/' . $this->photo);
                        break;
                    
                    default:
                        Yii::app()->ih
                            ->load($this->folder . '/' . $this->photo)
                            ->resize($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
                            ->save($this->folder . '/medium/' . $this->photo)
                            ->reload()
                            ->resize($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
                            ->save($this->folder . '/small/' . $this->photo);
                        break;
                }

                if($old_image){
                        //Удаляем старые картинки
                        @unlink($this->folder . '/' .$old_image);
                        @unlink($this->folder . '/medium/' .$old_image);
                        @unlink($this->folder . '/small/' .$old_image);
                }
			}else {$this->photo = $old_image;}

            $productImages=new CatalogImage;

			if	($productImagesUpload = CUploadedFile::getInstances($productImages, 'image')){
				foreach($productImagesUpload as $file){
					$productImages=new CatalogImage;
					$productImagesName = md5(time().$file->name).'.'.$file->getExtensionName();
					$productImages->image = $productImagesName;
					$file->saveAs($this->folder . '/moreimages/' . $productImagesName);
					$this->images[] = $productImages;
                    if(isset($catalog_config->watermark_image) && !$catalog_config->no_watermark){
                        Yii::app()->ih
                            ->load($this->folder . '/moreimages/' . $productImagesName)
                            ->watermark($this->folder . '/watermark/'.$catalog_config->watermark_image , $catalog_config->watermark_x, $catalog_config->watermark_y)
                            ->save();
                    }
                    // Способы изменения размера
                    switch($catalog_config->resize_mode){
                        case 2:
                            Yii::app()->ih
                                ->load($this->folder . '/moreimages/' . $productImagesName)
                                ->resizeCanvas($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
                                ->save($this->folder . '/moreimages/small/' . $productImagesName)
                                ->reload()
                                ->resizeCanvas($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
                                ->save($this->folder . '/moreimages/medium/' .$productImagesName);
                            break;

                        default:
                            Yii::app()->ih
                                ->load($this->folder . '/moreimages/' . $productImagesName)
                                ->resize($catalog_config->p_image_small_w, $catalog_config->p_image_small_h)
                                ->save($this->folder . '/moreimages/small/' . $productImagesName)
                                ->reload()
                                ->resize($catalog_config->p_image_middle_w, $catalog_config->p_image_middle_h)
                                ->save($this->folder . '/moreimages/medium/' .$productImagesName);
                            break;
                    }

				}
			}

			return true;
		}
		else
			return false;
	}

    //**********************************************************************
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
    protected function afterSave(){
        parent::afterSave();

		if (!empty($this->images)) {
			foreach($this->images as $image) {
				$image->id_product = $this->id;
				$image->save();
			}
		}
    }

    //**********************************************************************
    // Удаляем связанные модели
    protected function beforeDelete(){

        if(parent::beforeDelete())
        {
            // Удаляем дополнительные картинки товара
			foreach ($this->catalogImages as $image) {
				@unlink ($this->folder . '/moreimages/' . $image->image);
				@unlink ($this->folder . '/moreimages/medium/' . $image->image);
				@unlink ($this->folder . '/moreimages/small/'  . $image->image);

                $image->delete();
			}

            // Удаляем основную картинку товара и все ее копии
            @unlink ($this->folder . '/' . $this->photo);
            @unlink ($this->folder . '/medium/' . $this->photo);
            @unlink ($this->folder . '/small/' . $this->photo);

            // Удаляем все комплектации товара
            if(isset($this->complectations)){
                foreach($this->complectations as $complectation){
                   $complectation->delete();
                }
            }
            return true;
        }
        else
            return false;
    }


    //**********************************************************************
	public function getImages(){
		$attribute='';
		foreach($this->catalogImages as $image){
			$attribute.='{url: "/images/catalog/fasad/'.$image->image.'"},';
		}
		return $attribute;
	}

    //**********************************************************************
    //возвращает максимальное значение поля сортировки
	public function getMaxSortOrder(){
		$models=CatalogProduct::model()->findAll();
		foreach($models as $model) {
			$sort_orders[]=$model->sort_order;
		}
        if(!empty($sort_orders)){
            arsort($sort_orders);
            $max_order=current($sort_orders);
        } else{$max_order=0;}

		return $max_order;
	}

    //**********************************************************************
    // Форматирует цену $decimals знаков после запятой, $decpoint - символ, отделяющий десятичную часть
    // $groupspace - разделитель для групп разрядов. По умолчанию - 123456,78
    public function priceFormat($decimals=2, $decpoint=',', $groupspace=''){
        return number_format($this->price, $decimals, $decpoint, $groupspace);
    }

    // Выводит отформатированную цену с добавленным префиксом валюты
    public function outPrice($template='{price}', $decimals=2, $decpoint=',', $groupspace=''){
        if($this->thisCurrency->beforeprefix){
            return $this->thisCurrency->prefix.str_replace('{price}', $this->priceFormat($decimals, $decpoint, $groupspace), $template);
        } else {
            return str_replace('{price}', $this->priceFormat($decimals, $decpoint, $groupspace), $template).$this->thisCurrency->prefix;
        }
    }



    //**********************************************************************
    // Форматирует старую цену по аналогии с priceFormat
    public function old_priceFormat($decimals=2, $decpoint=',', $groupspace=''){
        return number_format($this->old_price, $decimals, $decpoint, $groupspace);
    }



    //**********************************************************************
    // Увеличение количества просмотров на 1
    public function incViews(){
        $this->views++;
        $this->save();
    }

    //*********************************************************************
    // Возвращает полную ссылку на товар.
    public function getFullLink(){
        if(isset($this->idCategory)){
                     // возвращаем путь к категории товара и прибавляем в конце id
                    return '/catalog'.CatalogCategory::getCategoryRoute($this->idCategory->link).'/'.$this->link.'.html';
        }  else {return '/catalog/'.$this->link.'.html';}
    }
	
	public static function getRandomProject(){
        $criteria = new CDbCriteria;
        $criteria->limit = 1;
        $criteria->select = "*, rand() as rand";
        $criteria->order = "rand";
        return CatalogProduct::model()->find($criteria);
    }

}