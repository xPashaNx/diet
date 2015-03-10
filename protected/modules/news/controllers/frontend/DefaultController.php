<?php

class DefaultController extends FrontEndController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    private $config;

    public function init()
    {
        $this->config = NewsConfig::model()->find();
        $this->title = $this->config->title;
    }

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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        //Фотогалерея
        $criteria = new CDbCriteria();
        $criteria->compare('news_id', $id);

        $imagesDataProvider = new CActiveDataProvider('NewsImages', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        //формируем title страницы, description, keywords
        $this->title = $model->title . " - " . $this->title;
        $this->description = $model->meta_description;
        $this->keywords = $model->meta_keywords;

        $this->render('view', array(
            'model' => $model,
            'titleListNews' => $this->config->title,
            'titleBreadcrumbs' => $model->link,
            'imagesDataProvider' => $imagesDataProvider,
            'folder_upload' => News::FOLDER_UPLOAD,

        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('News', array(
            'criteria' => array('condition' => 'public=1', 'order' => 'date DESC'),
            'pagination' => array('pageSize' => NewsConfig::model()->findByPk(1)->view_count),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'titleListNews' => $this->config->title,
            'folder_upload' => News::FOLDER_UPLOAD,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = News::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
