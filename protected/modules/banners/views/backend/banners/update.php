<?php
$this->breadcrumbs=array(
	'Управление баннерами'=>array('/banners'),
	'Редактирование баннера',
);

?>

<h1>Редактирование баннера &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'areaList'=>$areaList)); ?>