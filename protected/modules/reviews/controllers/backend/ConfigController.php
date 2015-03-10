<?php

/**
 * Class ConfigController
 */
class ConfigController extends BackEndController
{
    /**
     * Reviews config
     */
	public function actionIndex()
	{
        $model = ReviewsConfig::model()->findByPk(1);
		if (isset($_POST['ReviewsConfig']))
		{
            $model->attributes = $_POST['ReviewsConfig'];
            if($model->save())
                Yii::app()->user->setFlash('success',"Изменения успешно сохранены!");
        }
		$this->render('index',array(
			'model' => $model,
		));
	}
}