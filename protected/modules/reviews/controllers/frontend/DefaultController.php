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
     * List all reviews
     */
    public function actionIndex()
    {
        $reviewsConfig = ReviewsConfig::model()->find();

        $criteria = new CDbCriteria;
        $criteria->limit = $reviewsConfig->reviews_perpage;

        if ($reviewsConfig->premoder and Yii::app()->user->isGuest)
        {
            $criteria->condition = 'public = :public';
            $criteria->params = array(':public' => true);
        }

        $reviews = Reviews::model()->findAll($criteria);

        $reviewDataProvider = new CActiveDataProvider('Reviews', array(
            'sort' => array(
                'defaultOrder' => 'name ASC',
            ),
            'pagination'=>array(
                'pageSize' => 8,
            ),
        ));

        $this->render('index',array(
            'reviews' => $reviews,
            'reviewDataProvider' => $reviewDataProvider,
        ));
    }

    /**
     * Create new review
     */
    public function actionCreate()
    {
        $this->breadcrumbs['Каталог услуг'] = array('/services');
        $this->breadcrumbs[] = 'Добавление категории';

        $model = new Reviews;
        $reviewsConfig = ReviewsConfig::model()->find();

        if (isset($_POST['Reviews']))
        {
            $model->attributes = $_POST['Reviews'];
            if ($reviewsConfig->show_captcha)
                $model->setScenario('captcha');

            if ($model->save())
                if ($reviewsConfig->premoder)
                    Yii::app()->user->setFlash('success',"Ваш отзыв успешно добавлен и будет опубликован после проверки модератором!");
                else
                    Yii::app()->user->setFlash('success',"Ваш отзыв успешно добавлен!");
        }

        $this->render('create',array(
            'model' => $model,
            'reviewsConfig' => $reviewsConfig,
        ));
    }

    /**
     * Delete review
     *
     * @param integer $id
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if ($model->delete())
            $this->redirect(array('index'));
    }

    /**
     * Delete checked reviews
     *
     * @throws CHttpException
     */
    public function actionDeleteChecked()
    {
        $checkedReviews = Reviews::getCheckedReviews();
        foreach ($checkedReviews as $checkedReview)
            $checkedReview->delete();
        $this->redirect(array('index'));
    }

    /**
     * Public review
     *
     * @param integer $id
     * @param integer $flag
     *
     * @throws CHttpException
     */
    public function actionPublic($id, $flag)
    {
        $model = $this->loadModel($id);
        $model->public = $flag;

        if ($model->update())
            $this->redirect(array('index'));
    }

    /**
     * Public checked review
     *
     * @param integer $flag
     *
     * @throws CHttpException
     */
    public function actionPublicChecked($flag)
    {
        $checkedReviews = Reviews::getCheckedReviews();
        foreach ($checkedReviews as $checkedReview)
        {
            $checkedReview->public = $flag;
            $checkedReview->update();
        }
        $this->redirect(array('index'));
    }

    /**
     * Check
     *
     * @param integer $id
     * @param string $flag
     *
     * @throws CHttpException
     */
    public function actionCheck($id, $flag)
    {
        if (isset($id))
        {
            $model = $this->loadModel($id);
            if ($flag == 'true')
                $model->checked = true;
            else
                $model->checked = false;
            if ($model->update())
                $this->redirect(array('index'));
        }
    }

    /**
     * Check all
     */
    public function actionCheckAll()
    {
        if (isset($_POST['checkedIds']))
        {
            foreach ($_POST['checkedIds'] as $checkedId)
            {
                $model = $this->loadModel($checkedId);
                $model->checked = true;
                $model->update();
            }
        }
        $this->redirect(array('index'));
    }

    /**
     * Clear all
     */
    public function actionClearAll()
    {
        if (isset($_POST['checkedIds']))
        {
            foreach ($_POST['checkedIds'] as $checkedId)
            {
                $model = $this->loadModel($checkedId);
                $model->checked = false;
                $model->update();
            }
        }
        $this->redirect(array('index'));
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
        $model = Reviews::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }
}