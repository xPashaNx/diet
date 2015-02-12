<?php

class DefaultController extends BaseCatalogController
{
    public $category=0;

	public function actionIndex()
	{
		$this->breadcrumbs[]=$this->catalog_config->title;
        // устанавливаем условие для отбора - корневые категории
        /*$criteria=new CDbCriteria;
        $criteria->compare('parent_id', 0);

        $dataProvider = new CActiveDataProvider('CatalogCategory', array(
            'criteria'=>$criteria,
            'pagination'=>array(

                // Количество на странице берем из конфигурации каталога
                'pageSize'=>$this->catalog_config->cat_perpage,
                ),
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
        ));*/

		$products_criteria=new CDbCriteria;

		$products_criteria->compare('id_category', 0);

		$productDataProvider = new CActiveDataProvider('CatalogProduct', array(
			'criteria'=>$products_criteria,
			'pagination'=>array(
				'pageSize'=>$this->catalog_config->product_perpage,
				),
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));
		
        // формируем заголовок и метатеги старницы из значений, указанных в конфигурации каталога
        $this->metaInfoGenerate($this->catalog_config->title, $this->catalog_config->keywords, $this->catalog_config->description);
		
        // если указан шаблон - берем его
	    if($this->catalog_config->layout) $this->layout=$this->catalog_config->layout;
		
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
            'productDataProvider'=>$productDataProvider,
		));
	}

	public function actionCategory($link)

	{
		$category=$this->loadCategoryModel($link);
		$this->breadcrumbs=CatalogCategory::getBreadcrumbs($category->id,false);
		$this->breadcrumbs[]=$category->title;

        // формируем заголовок и метатеги старницы
        $this->metaInfoGenerate($category->title, $category->keywords, $this->catalog_config->description);

		$criteria=new CDbCriteria;

		$criteria->compare('parent_id',$category->id);

		$dataProvider = new CActiveDataProvider('CatalogCategory', array(
			'criteria'=>$criteria,
			'pagination'=>array(

                // Количество на странице берем из конфигурации каталога
				'pageSize'=>$this->catalog_config->cat_perpage,
				),
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));

		$products_criteria=new CDbCriteria;

		$products_criteria->compare('id_category',$category->id);
		$products_criteria->compare('on_main',1);

		$productDataProvider = new CActiveDataProvider('CatalogProduct', array(
			'criteria'=>$products_criteria,
			'pagination'=>array(
				'pageSize'=>$this->catalog_config->product_perpage,
				),
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
		));
		
		// Категория для лейаута
		$this->category=$category->id;
		
	
        // если указан шаблон - берем его
	    if($this->catalog_config->layout) $this->layout=$this->catalog_config->layout;
  
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
            'productDataProvider'=>$productDataProvider,
			'category'=>$category,
		));
	}

	public function actionProduct($id)
	{
		$model=$this->loadProductModel($id);

        // Увеличиваем количество просмотров на 1
        $model->incViews();
        
		$this->breadcrumbs=CatalogCategory::getBreadcrumbs($model->id_category, true);
		$this->breadcrumbs[]=$model->title;

        // формируем заголовок и метатеги старницы
        $this->metaInfoGenerate($model->title, $model->keywords, $this->catalog_config->description);

		// если указан шаблон - берем его
		$this->layout="//layouts/product";
		
		$this->render('product',array(
			'model'=>$model,
		));
	}

    public function actionSelection(){
        $this->breadcrumbs[]='Результаты подбора товаров';

        // если переданы параметры для отбора
        if(isset($_GET['selectionParameters'])){
            // Берем параметры для отбора из post-запроса
            $selectionParameters=$_GET['selectionParameters'];

            // берем указанную категорию
            $category=new CatalogCategory();
            $category->id=$selectionParameters['category'];
            $allCategoryIds=array_merge($category->allChildIds, (array)$category->id);

            // Формируем критерии отбора
            $criteria=new CDbCriteria;
            $criteria->order='sort_order ASC';
            $criteria->with='productAttrubute';
            $criteria->compare('id_category', $allCategoryIds);

            // Если указан бренд - добавляем к критерию
            if(isset($selectionParameters['brand'])){
                if($selectionParameters['brand'][0]){
                    $criteria->compare('brand',  $selectionParameters['brand']);
                }
            }


            // Выбираем все товары, удовлетворяющие критериям
            $allprod=CatalogProduct::model()->findAll($criteria);

            // Отбираем товары, удовлетворяющие параметрам поиска
            $selectedProd=array();
            foreach($allprod as $product){
                // Признак, берем ли данный продукт в выборку
                $addthis=true;

                // Проверяем по диапазону цены
                if($product->currencyPriceProfiled(1)<$selectionParameters['pricefrom'] || $product->currencyPriceProfiled(1)>$selectionParameters['priceto']){
                    $addthis=($addthis && false);
                }


                // Проверяем по значениям атрибутов
               /* foreach($product->productAttrubute as $attr){
                    // Берем только значения типа "список" и "Множественный выбор"
                    if(isset($selectionParameters['attributes'][$attr->idAttribute->name]) && ($attr->idAttribute->kind->id==3 || $attr->idAttribute->kind->id==4)){
                        $addthis=($addthis && in_array($attr->value, $selectionParameters['attributes'][$attr->idAttribute->name]));
                    }
                }*/
                if(isset($selectionParameters['attributes'])){
                    foreach($selectionParameters['attributes'] as $attr_key=>$attr_values){
                        // Берем значения данного атрибута у товара
                        $product_attr_values=$product->getProductAttributeValue($attr_key);
                        // Если значения атрибута товара пересекаются с массивом требуемых значений
                        $addthis=($addthis && array_intersect((array)$product_attr_values, $attr_values));
                    }
                }

                if($addthis) $selectedProd[]=$product;
            }

        } else {
            // Если параметры не переданы - берем все
            $criteria=new CDbCriteria;
            $criteria->order='sort_order ASC';
            $selectedProd=CatalogProduct::model()->findAll($criteria);
        }

        $dataProvider= new CArrayDataProvider($selectedProd, array(
            'pagination'=>array(
                'pageSize'=>$this->catalog_config->product_perpage,
                ),
        ));

        // если указан шаблон - берем его
        if($this->catalog_config->layout) $this->layout=$this->catalog_config->layout;

        $this->render('selectionresults', array(
               'dataProvider'=>$dataProvider,
        ));
    }

	public function loadCategoryModel($link)
	{
		$model=CatalogCategory::model()->findByAttributes(array('link'=>$link));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadProductModel($id)
	{
		$model=CatalogProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function createUrl($route,$params=array(),$ampersand='&'){
        // если формируем ссылку на категорию
        if($route=='category'){
            if(isset($params['link'])){return '/catalog'.CatalogCategory::getCategoryRoute($params['link']);}
        }

        // если формируем ссылку на товар
        if($route=='product'){
            // если передано id товара
            if(isset($params['id'])){
                // если существует такой продукт
                if($product=CatalogProduct::model()->find(array('condition'=>'id=:id', 'params'=>array(':id'=>$params['id']),))){

                    // берем категорию продукта
                    $category=CatalogCategory::model()->findByPk($product->id_category);

                    // возвращаем путь к категории товара и прибавляем в конце id
                    return '/catalog'.CatalogCategory::getCategoryRoute($category->link).'/'.$product->id;
                }
            }
        }
        // если условия не сработали - формируем адрес обычным образом
        return parent::createUrl($route,$params,$ampersand);
    }
}