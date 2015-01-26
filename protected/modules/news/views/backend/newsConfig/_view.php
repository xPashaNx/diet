<?php
/* @var $this NewsConfigController */
/* @var $data NewsConfig */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('view_count')); ?>:</b>
	<?php echo CHtml::encode($data->view_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('widget_count')); ?>:</b>
	<?php echo CHtml::encode($data->widget_count); ?>
	<br />


</div>