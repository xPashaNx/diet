<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class CallbackAdminmenuWidget
 */
class ServicesAdminmenuWidget extends CPortlet
{
	public function	init() {
		$this->title = 'Услуги';
		return parent::init();
	}

	public function	run() {
		$this->render('servicesAdminMenu');
		return parent::run();
	}
}
