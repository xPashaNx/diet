<?php

Yii::import('zii.widgets.CPortlet');

/**
 * Class BannersAdminmenuWidget to display the menu in the admin module
 */
class BannersAdminmenuWidget extends CPortlet {
	public function	init() {
		$this->title = 'Баннеры';
		return parent::init();
	}

	public function	run() {
		$this->render('banners_adminmenu');
		return parent::run();
	}

}
?>
