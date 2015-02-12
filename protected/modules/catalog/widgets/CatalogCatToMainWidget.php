<?php

Yii::import('zii.widgets.CListView');
Yii::import('application.modules.catalog.models.CatalogCategory');
Yii::import('application.modules.catalog.models.CatalogProduct');
/*
Класс виджета для вывода категорий на главную страницу

*/
class CatalogCatToMainWidget extends CListView {

    public $itemView='application.modules.catalog.widgets.views.cattomain';
    public $template='{items}<div class="clear"></div>';

	public function	init() {

        // устанавливаем условие для отбора - корневые категории
        $criteria=new CDbCriteria;
        $criteria->compare('parent_id', 0);

        $this->dataProvider = new CActiveDataProvider('CatalogCategory', array(
            'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order ASC',
				),
            'pagination'=>false,
        ));
        
		return parent::init();
	}

	public function	run() {

		return parent::run();
        
	}
	
}
?>
