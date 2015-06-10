<?php

/**
 * Class ServiceController
 */
class ServiceController extends BackEndController
{
    /**
     * @return array
     */
	public function actions()
	{
		return array(
			'move' => 'application.extensions.SSortable.SSortableAction',
		);
	} 

    /**
     * Displays CatalogService model
     *
     * @param integer $id the ID of the model to be displayed
     *
     * @throws CHttpException
     */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        $this->breadcrumbs = CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[] = $model->short_title;
		$this->breadcrumbs[] = 'Просмотр';

		$this->render('view',array(
			'model' => $model,
		));
	}

    /**
     * Creates a new model
     * If creation is successful, the browser will be redirected to the 'view' page
     *
     * @param integer $id_category
     */
	public function actionCreate($id_category = null)
	{
		$model = new CatalogService;
		$serviceImages = new CatalogImage;
		if ($id_category === null)
		{
			$this->breadcrumbs['Управление услугами'] = array('/services');
			$this->breadcrumbs[] = 'Добавление услуги';
		}
		else
		{
			$model->id_category = 0; //$id_category если категория выбирается из списка
			$this->breadcrumbs = CatalogCategory::getParents($model->id_category, true);
			$this->breadcrumbs[] = 'Добавление услуги';
		}

		if (isset($_POST['CatalogService']))
		{
			$model->attributes = $_POST['CatalogService'];
			if ($model->save())
				$this->redirect(array('view','id' => $model->id));
		}

		$this->render('create',array(
			'model' => $model,
            'serviceImages' => $serviceImages,
		));
	}

    /**
     * Updates a particular model
     * If update is successful, the browser will be redirected to the 'view' page
     *
     * @param integer $id the ID of the model to be updated
     *
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$serviceImages = new CatalogImage;

		$this->breadcrumbs = CatalogCategory::getParents($model->id_category, true);
		$this->breadcrumbs[] = $model->short_title;
		$this->breadcrumbs[] = 'Редактирование';

		if (isset($_POST['CatalogService']))
		{
			$model->attributes = $_POST['CatalogService'];
			if ($model->save())
				$this->redirect(array('view','id' => $model->id));
		}

		$this->render('update',array(
			'model' => $model,
			'serviceImages' => $serviceImages,
		));
	}

    /**
     * Delete a particular model
     *
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CHttpException
     */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
     * Returns the data model based on the primary key given in the GET variable
     * If the data model is not found, an HTTP exception will be raised
     *
     * @param $id the ID of the model to be loaded
     *
     * @return mixed
     * @throws CHttpException
     */
	public function loadModel($id)
	{
		$model = CatalogService::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

        return $model;
	}

    /**
     * Create Alt Text
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
