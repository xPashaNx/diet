<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */
/* @var $titleListNews NewsConfig */

$this->breadcrumbs=array(
	$titleListNews,
);
?>

<h1><?= $titleListNews ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>