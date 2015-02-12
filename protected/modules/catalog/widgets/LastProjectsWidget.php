<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.catalog.models.*');
/*
 *Класс виджета для вывода картинок категорий для смены при наведении на пункты меню
 *
*/
class LastProjectsWidget extends CWidget {

    public $limit=3;
	public $category=0;

	public function	run() {
		$childIds=array();
				
		$criteria=new CDbCriteria;
		if ($this->category>0) {
		$category=CatalogCategory::model()->findByPk($this->category);
		$childIds=$category->getAllChildIds();
		$childIds[]=$this->category;
		$criteria->compare('id_category',$childIds);
		}
		$criteria->order='date_added DESC';
		$criteria->limit=$this->limit;
		
        $projects=CatalogProduct::model()->findAll($criteria);

        $this->render('lastprojects', array(
                                         'projects'=>$projects,
                                       ));
        
		return parent::run();
        
	}

}
?>
