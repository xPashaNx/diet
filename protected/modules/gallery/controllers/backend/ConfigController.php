<?php

/**
 * Class ConfigController
 */
class ConfigController extends BackEndController
{
	public function actionIndex()
	{
		$model = GalleryConfig::model()->find();
        if (isset($_POST['GalleryConfig']))
        {
            $model->attributes = $_POST['GalleryConfig'];
            if ($model->save())
                Yii::app()->user->setFlash('success', "Изменения успешно сохранены!");
        }
		
		$this->render('index', array(
			'model' => $model
		));
	}
}