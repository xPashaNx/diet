<?php
$this->breadcrumbs=array(
	'Управление баннерами'=>array('index'),
	'Создание рекламного места',
);

?>

<h1>Создание рекламного места</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>