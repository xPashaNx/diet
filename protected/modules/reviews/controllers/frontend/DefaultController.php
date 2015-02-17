<?php

/**
 * Class DefaultController
 */
class DefaultController extends BaseReviewsController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
            ),
        );
    }

    /**
     * List all public reviews
     */
    public function actionIndex()
    {
        $reviews = Reviews::model()->findAllByAttributes(array('public' => true));

        $this->render('index',array(
            'reviews' => $reviews,
        ));
    }

    /**
     * Create new review
     */
    public function actionCreate()
    {
        $model = new Reviews;
        if (isset($_POST['Reviews']))
        {
            $model->attributes = $_POST['Reviews'];
            if ($model->save())
                Yii::app()->user->setFlash('success',"Ваш отзыв успешно добавлен!");
                //$this->redirect(array('index'));
        }

        $this->render('create',array(
            'model' => $model,
        ));
    }

    /**
     * Load product model
     *
     * @param integer $id
     *
     * @return mixed
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CatalogService::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }
}