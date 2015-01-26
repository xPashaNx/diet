<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */
/* @var $title NewsConfig */

$this->breadcrumbs=array(
	$title,
);
?>

<h1><?= $title ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>