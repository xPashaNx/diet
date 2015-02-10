<?php
$this->breadcrumbs=array(
	'Bannerareas',
);

$this->menu=array(
	array('label'=>'Create Bannerarea', 'url'=>array('create')),
	array('label'=>'Manage Bannerarea', 'url'=>array('admin')),
);
?>

<h1>Bannerareas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
