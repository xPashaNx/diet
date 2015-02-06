<?php
$this->breadcrumbs=array(
	'Управление галереями'=>array('index'),
	'Создание галереи',
);

?>

<h1>Создание галереи</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'photos'=>$photos)); ?>