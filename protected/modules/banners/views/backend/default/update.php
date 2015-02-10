<?php
$this->breadcrumbs = array(
	'Управление баннерами' => array('index'),
	'Редактирование рекламного места',
);

?>

<h1>Редактирование рекламного места &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>