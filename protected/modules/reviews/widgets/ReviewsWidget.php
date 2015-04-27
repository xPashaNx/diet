<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.reviews.models.*');

/**
 * Class ReviewsWidget to display banners
 */
class ReviewsWidget extends CWidget
{
    /**
     * @method run
     */
    public function	run()
    {

        $reviewsConfig = ReviewsConfig::model()->find();

        $criteria = new CDbCriteria;

        $criteria->order = 'date_create DESC';
        if ($reviewsConfig->premoder and Yii::app()->user->isGuest)
        {
            $criteria->condition = 'public = :public';
            $criteria->params = array(':public' => true);
        }

        $dataProvider = Reviews::model()->findAll($criteria);
        /*
        $dataProvider = new CActiveDataProvider('Reviews', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
*/
        $this->render('reviews', array(
            'dataProvider' => $dataProvider,
        ));

        return parent::run();
    }
}