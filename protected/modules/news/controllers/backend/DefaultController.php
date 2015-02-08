<?php

class DefaultController extends BackEndController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = '//layouts/column2';

    private $config;

    public function init()
    {
        $this->config = NewsConfig::model()->find();
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new News;
        $imageModel = new NewsImages();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            $model->cover_id = 0;

            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'titleListNews' => $this->config->title,
            'imageModel' => $imageModel,
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        //Фотогалерея
        $imageModel = new NewsImages();

        $criteria = new CDbCriteria();
        $criteria->compare('news_id', $id);

        $imagesDataProvider = new CActiveDataProvider('NewsImages', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];

            if (isset($_POST['NewsImages']['id']))
                $model->cover_id = $_POST['NewsImages']['id'];

            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
            'titleListNews' => $this->config->title,
            'imageModel' => $imageModel,
            'imagesDataProvider' => $imagesDataProvider,
            'folder_upload' => News::FOLDER_UPLOAD,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //$dataProvider = new CActiveDataProvider('News');

        $model = new News('search');
        $model->unsetAttributes();  // clear any default values

        $criteria = new CDbCriteria();

        if (isset($_GET['News'])) {
            $model->attributes = $_GET['News'];

            if (isset($_GET['beginDate']) && isset($_GET['endDate'])) {
                $criteria->addBetweenCondition('date', $_GET['beginDate'], $_GET['endDate']);
            }
        }

        $this->render('index', array(
            'model' => $model,
            'titleListNews' => $this->config->title,
            'criteria' => $criteria,
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

    public function loadImageModel($id)
    {
        $model = NewsImages::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionDeleteImage($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadImageModel($id);
            //удаляем картинку из папки
            @unlink(News::FOLDER_UPLOAD . '/' . $model->filename);

            //удаляем картинку из БД
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('update', 'id' => $model->news_id));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}
