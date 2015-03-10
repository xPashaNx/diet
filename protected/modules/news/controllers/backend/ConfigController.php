<?php

class ConfigController extends BackEndController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * view all models.
     */
    public function actionIndex()
    {
        $model = NewsConfig::model()->find();

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        if (isset($_POST['NewsConfig'])) {
            $model->attributes = $_POST['NewsConfig'];
            if ($model->save()) {
                Yii::app()->user->setFlash('newsConfig', 'Данные успешно изменены.');
            } else {
                Yii::app()->user->setFlash('newsConfig', 'Ошибка изменения данных!!!.');
            }
            $this->refresh();
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }
}
