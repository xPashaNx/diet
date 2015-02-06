<?php

class DefaultController extends BackEndController
{
	public function actions()
	{
		return array(
			'move' => 'application.extensions.SSortable.SSortableAction',
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Gallery;
        $photos = new GalleryPhoto();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Gallery']))
		{
			$model->attributes = $_POST['Gallery'];
			if ($photoCover = $model->getCover())
				$model->cover_photo_id = $photoCover->id;
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model' => $model,
            'photos' => $photos,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $photos = new GalleryPhoto();

        // Фотографии галереи
		$criteria = new CDbCriteria;
        $criteria->compare('gallery_id', $model->id);
        $photoDataProvider = new CActiveDataProvider('GalleryPhoto', array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
			),
			'pagination' => false,
		));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Gallery']))
		{
			$model->attributes = $_POST['Gallery'];
			if ($photoCover = $model->getCover())
				$model->cover_photo_id = $photoCover->id;
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model' => $model,
            'photoDataProvider' => $photoDataProvider,
            'photos' => $photos,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletephoto($id)
	{
		if (Yii::app()->request->isPostRequest)
		{

			// we only allow deletion via POST request
			$model = $this->loadModelPhoto($id);
			$gallery = $this->loadModel($model->gallery_id);

            $folder = 'upload/gallery';
            // удаляем картинки
            @unlink($folder . '/' .$model->file);
            @unlink($folder . '/small/' .$model->file);
            @unlink($folder . '/medium/' .$model->file);
			
			if ($gallery->cover_photo_id == $id)
			{
				$gallery->cover_photo_id = null;
				$gallery->save('cover_photo_id');
			}

            $model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('update', 'id'=>$model->gallery_id));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Gallery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];

		$this->render('index',array(
			'model'=>$model,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = Gallery::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
        
		return $model;
	}

	public function loadModelPhoto($id)
	{
		$model = GalleryPhoto::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
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
			$model = $this->loadModelPhoto($photoId);
			$model->alt_text = $_POST['value'];
			$model->save('alt_text');
			echo $model->alt_text;
		}
	}
}