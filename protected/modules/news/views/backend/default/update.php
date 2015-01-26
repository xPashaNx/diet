<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $title NewsConfig */

$this->breadcrumbs=array(
	$title => array('index'),
	$model->title=>array('index','id'=>$model->id),
	'Редактирование',
);
?>

<h1>Редактировать: <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>