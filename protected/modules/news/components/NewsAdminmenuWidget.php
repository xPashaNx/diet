<?php

Yii::import('zii.widgets.CPortlet');

class NewsAdminmenuWidget extends CPortlet {

    public function init() {
        $this->title = 'Новости';
        parent::init();
    }

    protected function renderContent() {
        $this->render('news');
    }

}
