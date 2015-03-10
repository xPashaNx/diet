<?php

/**
 * Class ConfigController
 */
class ConfigController extends BackEndController
{
    /**
     * Output config
     */
	public function actionIndex()
	{
        $model = CatalogConfig::model()->findByPk(1);
		if (isset($_POST['CatalogConfig']))
		{
            $model->attributes=$_POST['CatalogConfig'];
            if($model->save())
                Yii::app()->user->setFlash('success',"Изменения успешно сохранены!");
        }
		$this->render('index',array(
			'model'=>$model,
		));
	}
}