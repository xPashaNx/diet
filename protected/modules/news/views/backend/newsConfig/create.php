<?php
/* @var $this NewsConfigController */
/* @var $model NewsConfig */

$this->breadcrumbs=array(
	'News Configs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewsConfig', 'url'=>array('index')),
	array('label'=>'Manage NewsConfig', 'url'=>array('admin')),
);
?>

<h1>Create NewsConfig</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>