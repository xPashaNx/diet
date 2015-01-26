<?php
/* @var $this NewsConfigController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'News Configs',
);

$this->menu=array(
	array('label'=>'Create NewsConfig', 'url'=>array('create')),
	array('label'=>'Manage NewsConfig', 'url'=>array('admin')),
);
?>

<h1>News Configs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
