<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.catalog.models.*');
/*
 *Класс виджета для вывода случайного фото из галерей
 *
*/
class RandomProjectWidget extends CWidget {

	public function	run() {

        $project=CatalogProduct::getRandomProject();

        $this->render('randomproject', array(
                                         'project'=>$project,
                                       ));
        
		return parent::run();
        
	}

}
?>
