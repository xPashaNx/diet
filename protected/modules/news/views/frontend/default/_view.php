<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="news">
    <b><?= CHtml::link($data->title, Yii::app()->createUrl('news/default/view', array('id' => $data->id))); ?></b>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('annotation')); ?>:</b>
    <?php echo CHtml::encode($data->annotation); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br />
    <hr/>
</div>
