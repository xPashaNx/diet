<?php

Yii::import('zii.widgets.CListView');
Yii::import('application.modules.services.models.CatalogCategory');
Yii::import('application.modules.services.models.CatalogService');

class CatalogCatToMainWidget extends CListView
{
    public $itemView='application.modules.services.widgets.views.cattomain';
    public $template='{items}<div class="clear"></div>';

	public function	init()
    {
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
