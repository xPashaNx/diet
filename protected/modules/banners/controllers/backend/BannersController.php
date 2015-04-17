<?php

/**
 * Class BannersController
 */
class BannersController extends BackEndController
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
     * Creates a new model
     * If creation is successful, the browser will be redirected to the 'view' page
     * @param integer $bannerarea
     */
	public function actionCreate($bannerarea)
	{
		$model = new Banners;
        $model->content_type = 1;
        $model->bannerarea = $bannerarea;

        $areaList = Bannerarea::createAreaList();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Banners']))
		{
			$model->attributes = $_POST['Banners'];
			if ($model->save())
				$this->redirect(array('/banners'));
		}

		$this->render('create',array(
			'model' => $model,
            'areaList' => $areaList,
		));
	}

	/**
	 * Updates a particular model
	 * If update is successful, the browser will be redirected to the 'view' page
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

        $areaList = Bannerarea::createAreaList();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Banners']))
		{
			$model->attributes = $_POST['Banners'];
			if ($model->save())
				$this->redirect(array('/banners'));
		}

		$this->render('update',array(
			'model' => $model,
            'areaList' => $areaList,
		));
	}

    /**
     * Deletes a particular model
     * If deletion is successful, the browser will be redirected to the 'admin' page
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CHttpException
     */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			@unlink($model->folder . '/' . $model->image);
			$model->delete();
				
			
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
     * Returns the data model based on the primary key given in the GET variable
     * If the data model is not found, an HTTP exception will be raised
     * @param $id the ID of the model to be loaded
     *
     * @throws CHttpException
     * @return model
     * @internal param the $integer ID of the model to be loaded
     */
	public function loadModel($id)
	{
		$model = Banners::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    /**
     * Performs the AJAX validation
     * @param $model the model to be validated
     */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
