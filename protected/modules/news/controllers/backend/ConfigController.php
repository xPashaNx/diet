<?php

class ConfigController extends BackEndController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * view all models.
     */
    public function actionIndex() {
        $model = NewsConfig::model()->findByPk(1);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        if (isset($_POST['NewsConfig'])) {
            $model->attributes = $_POST['NewsConfig'];
            if ($model->save()) {
                Yii::app()->user->setFlash('newsConfig', 'Данные успешно изменены.');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('newsConfig', 'Ошибка изменения данных!!!.');
                $this->refresh();
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param NewsConfig $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-config-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
