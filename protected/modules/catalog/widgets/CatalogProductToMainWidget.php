<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.*');
/*
 *Класс виджета для вывода товаров на главную страницу
 *
*/
class CatalogProductToMainWidget extends CPortlet {

	public function	run() {

        // устанавливаем условие для отбора - корневые категории
        $criteria=new CDbCriteria;
        $criteria->compare('on_main', true);

        $dataProvider = new CActiveDataProvider('CatalogProduct', array(
            'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
            'pagination'=>false,
        ));

		$this->render('prodtomain',array(
                           'dataProvider'=>$dataProvider,
        ));
        
		return parent::run();
        
	}

}
?>
