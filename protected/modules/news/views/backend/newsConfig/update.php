<?php
/* @var $this NewsConfigController */
/* @var $model NewsConfig */

$this->breadcrumbs=array(
	'News Configs'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NewsConfig', 'url'=>array('index')),
	array('label'=>'Create NewsConfig', 'url'=>array('create')),
	array('label'=>'View NewsConfig', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NewsConfig', 'url'=>array('admin')),
);
?>

<h1>Update NewsConfig <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>