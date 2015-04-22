<?php

/**
 * Class ImageController
 */
class ImageController extends BackEndController
{
	/**
	 * Displays CatalogImage model
     *
	 * @param integer $id the ID of the model to be displayed
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
	 */
	public function actionCreate()
	{
		$model = new CatalogImage;

		if (isset($_POST['CatalogImage']))
		{
			$model->attributes = $_POST['CatalogImage'];
			if($model->save())
				$this->redirect(array('view','id' => $model->id));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model
	 * If update is successful, the browser will be redirected to the 'view' page
     *
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['CatalogImage']))
		{
			$model->attributes = $_POST['CatalogImage'];
			if ($model->save())
				$this->redirect(array('view','id' => $model->id));
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

    /**
     * Deletes a particular model
     * If deletion is successful, the browser will be redirected to the 'admin' page
     *
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CHttpException
     */
	public function actionDelete($id)
	{
		if (Yii::app()->request->requestType == 'GET')
		{
            $model = $this->loadModel($id);
			$folder = 'upload/catalog/service/moreimages';
            unlink ($folder . '/' . $model->image);
            unlink ($folder . '/small/' . $model->image);
            unlink ($folder . '/medium/' . $model->image);
			$model->delete();

			if (!isset($_POST['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('service/update', 'id' => $model->id_service));
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
     * @throws CHttpException
     */
	public function loadModel($id)
	{
		$model = CatalogImage::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

		return $model;
	}

    /**
     * Sort photo
     *
     * @param integer $serviceId
     */
    public function actionSortPhoto($serviceId)
    {
        if (isset($_POST['sortArr']))
        {
			var_dump($_POST['sortArr']);

            $sortData = $_POST['sortArr'];
            $photos = CatalogImage::model()->findAllByAttributes(array('id_service' => $serviceId), array('order' => 'sort_order'));
            foreach ($photos as $key => $photo)
            {
                $photo->sort_order = $sortData[$key];
                $photo->save('sort_order');
            }
        }
    }
}