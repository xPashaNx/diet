<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $title NewsConfig */
/* @var $imageModel NewsImages*/

$this->breadcrumbs=array(
	$title,
	'Добавление новости',
);
?>

<h1>Добавление новости</h1>

<?php $this->renderPartial('_form', array('model'=>$model, /*'imageModel' => $imageModel*/)); ?>