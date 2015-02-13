<?php

/**
 * Class DefaultController
 */
class DefaultController extends BackEndController
{
    /**
     * @return array
     */
	public function actions()
	{
		return array(
			'move'=>'application.modules.services.components.SSortable.SSortableAction',
		);
	}

    /**
     * Output category
     *
     * @param integer $id
     */
	public function actionView($id)
	{
		$this->render('view',array(
			'model' => $this->loadModel($id),
		));
	}

    /**
     * Creates a new model
     * If creation is successful, the browser will be redirected to the 'view' page
     *
     * @param integer $id
     */
	public function actionCreate($id)
	{
		$model = new CatalogCategory;
		$model->parent_id = $id;
		$this->breadcrumbs['Каталог услуг'] = array('/services');
		$this->breadcrumbs[] = 'Добавление категории';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['CatalogCategory']))
		{
			$model->attributes = $_POST['CatalogCategory'];
			if ($model->save())
				$this->redirect(array('index','id' => $model->parent_id));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

    /**
     * Updates a particular model
     * If update is successful, the browser will be redirected to the 'view' page
     *
     * @param integer $id
     *
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$this->breadcrumbs = CatalogCategory::getParents($model->id);
		$this->breadcrumbs[] = $model->short_title;
		$this->breadcrumbs[] = 'Редактирование';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['CatalogCategory']))
		{
			$model->attributes = $_POST['CatalogCategory'];
			if ($model->save())
				$this->redirect(array('index','id' => $model->parent_id));
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

    /**
     * Delete category
     * todo запретить удаление при наличии подкатегорий и товаров в категории
     *
     * @param integer $id
     *
     * @throws CHttpException
     */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
            $model = $this->loadModel($id);
            @unlink($model->folder . '/' .$model->image);
            @unlink($model->folder . '/small/' .$model->image);

			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
     * Output category (categories and services)
     *
     * @param int $id
     */
	public function actionIndex($id = 0)
	{

        if (!$category = $this->loadModel($id))
        {
            $category = new CatalogCategory();
            $category->id = 0;
            $category->short_title = 'Каталог услуг';
        }
		$this->breadcrumbs = CatalogCategory::getParents($category->id);
		$this->breadcrumbs[] = $category->short_title;

        $category_criteria = new CDbCriteria;
		$category_criteria->compare('parent_id',$category->id);

		$categoryDataProvider = new CActiveDataProvider('CatalogCategory', array(
			'criteria' => $category_criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
			),
			'pagination' => false,
		));

        $services = new CatalogService('search');
        $services->unsetAttributes();
        $services->id_category = $category->id;

		if (isset($_GET['CatalogService']))
            $services->attributes = $_GET['CatalogService'];

		$this->render('index',array(
            'services' => $services,
            'categoryDataProvider' => $categoryDataProvider,
			'category' => $category,
		));
	}

    /**
     * Load category model
     *
     * @param $id
     *
     * @return mixed
     */
	public function loadModel($id)
	{
        $result = null;
		if ($model = CatalogCategory::model()->findByPk($id))
            $result = $model;

		return $result;
	}

	/**
	 * Performs the AJAX validation
     *
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'catalog-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}