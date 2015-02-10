<?php
$this->breadcrumbs = array(
	'Bannerareas' => array('index'),
	$model->name => array('view','id' => $model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'List Bannerarea', 'url'=>array('index')),
	array('label'=>'Create Bannerarea', 'url'=>array('create')),
	array('label'=>'View Bannerarea', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Bannerarea', 'url'=>array('admin')),
);
?>

<h1>Update Bannerarea <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>