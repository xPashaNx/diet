<?php
$this->breadcrumbs=array(
	'Bannerareas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bannerarea', 'url'=>array('index')),
	array('label'=>'Manage Bannerarea', 'url'=>array('admin')),
);
?>

<h1>Create Bannerarea</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>