<?php
Yii::import('application.modules.services.models.CatalogService');
Yii::import('application.modules.services.models.CatalogConfig');

class MainPageServicesWidget extends CWidget{
    public function run(){
        $limit = CatalogConfig::model()->findByPk(1,array('select'=>'widget_count'));
        $limit=$limit->widget_count;

        $criteria = new CDbCriteria;
        $criteria->limit=$limit;
        $criteria->order='id ASC';

        $services = CatalogService::model()->findAll($criteria);

        $this->render('main_page_services',array(
            'services'=>$services
        ));
    }
}