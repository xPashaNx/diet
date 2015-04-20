<?php

/**
 * Class DefaultController
 */
class DefaultController extends BackEndController
{
	/**
	 * Creates a new model
	 * If creation is successful, the browser will be redirected to the 'view' page
	 */
	public function actionCreate()
	{
		$model = new Bannerarea;
		if (isset($_POST['Bannerarea']))
		{
			$model->attributes = $_POST['Bannerarea'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

    /**
     * Updates a particular model
     * If update is successful, the browser will be redirected to the 'view' page
     * @param integer $id the ID of the model to be updated
     *
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (isset($_POST['Bannerarea']))
		{
			$model->attributes = $_POST['Bannerarea'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model' => $model,
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
			$this->loadModel($id)->delete();

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Bannerarea');
		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

    /**
     * Returns the data model based on the primary key given in the GET variable
     * If the data model is not found, an HTTP exception will be raised
     * @param integer $id the ID of the model to be loaded
     *
     * @return mixed
     * @throws CHttpException
     */
	public function loadModel($id)
	{
		$model = Bannerarea::model()->findByPk($id);
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
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'bannerarea-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}