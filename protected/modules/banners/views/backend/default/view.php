<?php
$this->breadcrumbs=array(
	'Bannerareas'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Bannerarea', 'url'=>array('index')),
	array('label'=>'Create Bannerarea', 'url'=>array('create')),
	array('label'=>'Update Bannerarea', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Bannerarea', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bannerarea', 'url'=>array('admin')),
);
?>

<h1>View Bannerarea #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'widget',
	),
)); ?>
