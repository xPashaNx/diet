<?php
/* @var $this NewsConfigController */
/* @var $model NewsConfig */

$this->breadcrumbs=array(
	'News Configs'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List NewsConfig', 'url'=>array('index')),
	array('label'=>'Create NewsConfig', 'url'=>array('create')),
	array('label'=>'Update NewsConfig', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewsConfig', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewsConfig', 'url'=>array('admin')),
);
?>

<h1>View NewsConfig #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'view_count',
		'widget_count',
	),
)); ?>
