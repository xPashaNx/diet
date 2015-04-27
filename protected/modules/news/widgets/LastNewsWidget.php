<?php
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

        $news = News::model()->findAll($criteria);

        $this->render('lastnews', array(
            'news' => $news,
        ));

        return parent::run();
    }

}