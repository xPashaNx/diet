<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.services.models.*');

/**
 * Class CatalogServiceToMainWidget
 */
class CatalogServiceToMainWidget extends CPortlet
{
	public function	run()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('on_main', true);

        $dataProvider = new CActiveDataProvider('CatalogService', array(
            'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
			),
            'pagination' => false,
        ));

		$this->render('servicetomain', array(
           'dataProvider' => $dataProvider,
        ));
        
		return parent::run();
	}
}