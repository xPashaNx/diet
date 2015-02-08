<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div>
        <div class="row">
            <?php echo CHtml::label('Поиск по диапазону дат:', 'for'); ?>
        </div>
        <div class="row">
            <?php echo CHtml::label('От', 'for'); ?>
            <?php echo CHtml::dateField('beginDate'); ?>
        </div>

        <div class="row">
            <?php echo CHtml::label('До', 'for'); ?>
            <?php echo CHtml::dateField('endDate'); ?>
        </div>
    </div>>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
    </div>


    <div class="row">
        <?php echo $form->label($model, 'Опубликована'); ?>
        <?php echo $form->dropDownList($model, 'public', array('' => '', 1 => 'Да', 0 => 'Нет')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Поиск'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->