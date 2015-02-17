<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class ServicesAdminmenuWidget
 */
class ServicesAdminmenuWidget extends CPortlet
{
    /**
     * Init
     *
     * @return mixed
     */
	public function	init() {
		$this->title = 'Услуги';
		return parent::init();
	}

    /**
     * Run
     *
     * @return mixed
     */
	public function	run() {
		$this->render('servicesAdminMenu');
		return parent::run();
	}
}
