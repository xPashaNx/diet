<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class ReviewsAdminmenuWidget
 */
class ReviewsAdminmenuWidget extends CPortlet
{
	public function	init() {
		$this->title = 'Отзывы';
		return parent::init();
	}

	public function	run() {
		$this->render('reviewsAdminMenu');
		return parent::run();
	}
}
