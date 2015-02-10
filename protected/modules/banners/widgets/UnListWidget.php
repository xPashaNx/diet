<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.banners.models.*');
/*
 *Класс виджета для вывода картинок категорий для смены при наведении на пункты меню
 *
*/
class UnListWidget extends CWidget {

    public $limit=4;
	public $areaname='';
	public $banners='';

	public function	run() {
		if($bannerarea=Bannerarea::model()->find('name=:name', array('name'=>$this->areaname))){
		
			$criteria=new CDbCriteria;
			$criteria->condition='bannerarea=:bannerarea AND notactive<>1';
			$criteria->params=array('bannerarea'=>$bannerarea->id);
            $criteria->order='sort_order';

			$banners=Banners::model()->findAll($criteria);
			if($bannerarea->mode==4){shuffle($banners);}

			$this->render('unlistview', array(
											 'banners'=>$banners,
										   ));
			
			return parent::run();
			}
	}

}
?>