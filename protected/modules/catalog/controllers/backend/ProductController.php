<?php

class ProductController extends BackEndController
{
	/**
	 * Контроллер товаровъ
     *
	 */
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			'move'=>'application.modules.catalog.components.SSortable.SSortableAction',
		);
	} 

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]=$model->title;
		$this->breadcrumbs[]='Просмотр';


		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id_category)
	{
		$model=new CatalogProduct;
		$model->id_category=$id_category;
		$this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]='Добавление товара';

		$productImages=new CatalogImage;

		$folder = 'images/catalog';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogProduct']))
		{
			$model->attributes=$_POST['CatalogProduct'];

			if($model->save()) {
                // записываем атрибуты товара, переданные из формы
                if(isset($_POST['CatalogProductAttribute'])){$model->productAttributeSave($_POST['CatalogProductAttribute']);}

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'productImages'=>$productImages,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$productImages=new CatalogImage;

		$this->breadcrumbs=CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[]=$model->title;
		$this->breadcrumbs[]='Редактирование';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogProduct']))
		{
			$model->attributes=$_POST['CatalogProduct'];


           // if(isset($_POST['CatalogProductAttribute'])){
              //  $model->productAttrubute=$_POST['CatalogProductAttribute'];
            //}
			if($model->save()) {

                // записываем атрибуты товара, переданные из формы
                if(isset($_POST['CatalogProductAttribute'])){
                    $model->productAttributeSave($_POST['CatalogProductAttribute']);
                }

				$this->redirect(array('view','id'=>$model->id));

			}
		}
        //print_r($model->productAttrubute);

		$this->render('update',array(
			'model'=>$model,
			'productImages'=>$productImages,
		));
	}

	/**
	 * Удаление
     *
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);

			// Удаляем товар
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteAttribut($id)
	{
		if(Yii::app()->request->requestType=='GET')
		{
			$model=CatalogProductAttribute::model()->findByPk($id);
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('product/update', 'id'=>$model->id_product));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CatalogProduct');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CatalogProduct('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogProduct']))
			$model->attributes=$_GET['CatalogProduct'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Добавление связи между товарами (сопутствующего товара)
     *
	 */
	public function actionAddRelation($id, $product)
	{
		if(Yii::app()->request->isPostRequest)
		{
            // Нельзя делать связь продукта с самим с собой
            if($id<>$product){
                // Загружаем исходный продукт
                $thisProd=$this->loadModel($product);

                // Проверяем, нет ли уже запрашиваемой связи
                $find=false;
                foreach($thisProd->related_products as $related_product){
                    if($related_product->id==$id) $find=true;
                }

                // Если не нашли
                if(!$find){
                     // Создаем новую связь
                    $relation=new CatalogRelatedproducts();
                    $relation->product_id=$product;
                    $relation->related_product=$id;
                    $relation->save();
                } else {throw new CHttpException(400, 'Связь между данными товарами уже установлена');}

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

            } else {throw new CHttpException(400, 'Нельзя связать товар сам с собой');}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

	}

	/**
	 * Удаление связи между товарами (сопутствующего товара)
     *
	 */
	public function actionDeleteRelation($id, $product)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$relations = CatalogRelatedproducts::model()->findAll(array(
                        'condition'=>'product_id=:product_id AND related_product=:related_product',
                        'params'=>array('product_id'=>$product, 'related_product'=>$id),
            ));

            // Удаляем все связи двух данных товаров друг с другом
            foreach($relations as $relation) $relation->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CatalogProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * Creates Alt Text to
     */
    public function actionCreateAltText()
    {
        if (isset($_POST))
        {
            $photoId = $_POST['id'];
            $model = CatalogImage::model()->findByPk($photoId);
            $model->alt_text = $_POST['value'];
            $model->save('alt_text');
            echo $model->alt_text;
        }
    }
}
