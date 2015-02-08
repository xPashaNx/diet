<?php

//Yii::import('zii.widgets.CWidget');
//Yii::import('zii.web.widgets.CWidget');
Yii::import('application.modules.news.models.News');
Yii::import('application.modules.news.models.NewsConfig');

class LastNewsWidget extends CWidget {

    public function run() {
        $limit = NewsConfig::model()->findByPk(1, array('select' => 'widget_count'));
        $limit = $limit->widget_count;

        $criteria = new CDbCriteria;
        $criteria->compare('public', 1);
        $criteria->limit = $limit;
        $criteria->order = 'date DESC';

        $dataProvider = new CActiveDataProvider('News', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        $this->render('lastnews', array(
            'dataProvider' => $dataProvider,
        ));

        return parent::run();
    }

}