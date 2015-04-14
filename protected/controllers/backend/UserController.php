<?php

class UserController extends BackEndController
{
	public function actionChangePassword($id = null)
	{
		if ($id === null)
			$id = Yii::app()->user->id;
			
		$model = $this->loadModel($id);
		$oldPassword = $model->password;
		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->validate(array('newPassword', 'confirmNewPassword')) and $model->save(false))
				Yii::app()->user->setFlash('success', "Пароль успешно изменен!");
		}
		
		$this->render('changepassword', array(
			'model' => $model
		));
	}
	
	public function actionChangeEmail($id = null)
	{
		if ($id === null)
			$id = Yii::app()->user->id;
			
		$model = $this->loadModel($id);
		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->validate(array('email')) and $model->save(false))
				Yii::app()->user->setFlash('success', "Email успешно изменен!");
		}
		
		$this->render('changeemail', array(
			'model' => $model
		));
	}
	
	public function actionChangeLogin($id = null)
	{
		if ($id === null)
			$id = Yii::app()->user->id;
			
		$model = $this->loadModel($id);
		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->validate(array('username')) and $model->save(false))
				Yii::app()->user->setFlash('success', "Логин успешно изменен!");
		}
		
		$this->render('changelogin', array(
			'model' => $model
		));
	}
	
	/**
	 * Returns the data model of user
	 */
	public function loadModel($id)
	{
		$model = User::model()->findbyPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
			
		return $model;
	}
}
?>