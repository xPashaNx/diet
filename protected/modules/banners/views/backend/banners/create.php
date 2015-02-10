<?php
$this->breadcrumbs=array(
	'Управление баннерами'=>array('/banners'),
	'Создание баннера',
);

?>

<h1>Создание баннера</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'areaList'=>$areaList)); ?>