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
        $criteria->order = 'date_create DESC';
        if ($reviewsConfig->premoder and Yii::app()->user->isGuest)
        {
            $criteria->condition = 'public = :public';
            $criteria->params = array(':public' => true);
        }
        $model = new Reviews('search');
        $model->unsetAttributes();

        if (isset($_GET['Reviews']))
            $model->attributes = $_GET['Reviews'];

        $reviews =  new CActiveDataProvider('Reviews', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $reviewsConfig->reviews_perpage),
        ));

        $this->render('index',array(
            'reviews' => $reviews,
            'model' => $model,
            'captcha' => $reviewsConfig->show_captcha,
        ));
    }

    /**
     * Create new review
     */
    public function actionCreate()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new Reviews;
            $reviewsConfig = ReviewsConfig::model()->find();

            if ($reviewsConfig->show_captcha)
                $model->setScenario('captcha');

            if (isset($_POST['Reviews']))
            {
                $model->attributes = $_POST['Reviews'];
                $model->date_create = date('Y-m-d H:i:s');
                if ($model->save())
                {
                    if ($reviewsConfig->premoder)
                        Yii::app()->user->setFlash('success',"Ваш отзыв успешно добавлен и будет опубликован после проверки модератором!");
                    else
                        Yii::app()->user->setFlash('success',"Ваш отзыв успешно добавлен!");
                }
            }
            $this->renderPartial('_form',array(
                'model' => $model,
                'reviewsConfig' => $reviewsConfig,
                'captcha' => $reviewsConfig->show_captcha,
            ));
        }
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
            $this->redirect(array('/reviews'));
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
            $this->redirect(array('/reviews'));
    }

    /**
     * Delete checked reviews
     *
     * @throws CHttpException
     */
//    public function actionDeleteChecked()
//    {
//        $checkedReviews = Reviews::getCheckedReviews();
//        foreach ($checkedReviews as $checkedReview)
//            $checkedReview->delete();
//        $this->redirect(array('/reviews'));
//    }

    /**
     * Public checked review
     *
     * @param integer $flag
     *
     * @throws CHttpException
     */
//    public function actionPublicChecked($flag)
//    {
//        $checkedReviews = Reviews::getCheckedReviews();
//        foreach ($checkedReviews as $checkedReview)
//        {
//            $checkedReview->public = $flag;
//            $checkedReview->update();
//        }
//        $this->redirect(array('/reviews'));
//    }

    /**
     * Check
     *
     * @param integer $id
     * @param string $flag
     *
     * @throws CHttpException
     */
//    public function actionCheck($id, $flag)
//    {
//        if (isset($id))
//        {
//            $model = $this->loadModel($id);
//            if ($flag == 'true')
//                $model->checked = true;
//            else
//                $model->checked = false;
//            if ($model->update())
//                $this->redirect(array('/reviews'));
//        }
//    }

    /**
     * Check all
     */
//    public function actionCheckAll()
//    {
//        if (isset($_POST['checkedIds']))
//        {
//            foreach ($_POST['checkedIds'] as $checkedId)
//            {
//                $model = $this->loadModel($checkedId);
//                $model->checked = true;
//                $model->update();
//            }
//        }
//        $this->redirect(array('/reviews'));
//    }

    /**
     * Clear all
     */
//    public function actionClearAll()
//    {
//        if (isset($_POST['checkedIds']))
//        {
//            foreach ($_POST['checkedIds'] as $checkedId)
//            {
//                $model = $this->loadModel($checkedId);
//                $model->checked = false;
//                $model->update();
//            }
//        }
//        $this->redirect(array('/reviews'));
//    }

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