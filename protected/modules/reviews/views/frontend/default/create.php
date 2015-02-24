<?php
$this->breadcrumbs = array(
    'Отзывы' => array('/reviews'),
    'Добавление отзыва',
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>

    <div class="flash-success">
        <?php  echo Yii::app()->user->getFlash('success');?>
    </div>

<?php else: ?>

    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reviewscreate-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'enableAjaxValidation' => false,
        )); ?>
        <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
        <?php echo $form->errorSummary(array($model)); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'text'); ?>
            <?php echo $form->textArea($model, 'text', array('cols' => 60, 'rows' => 4)); ?>
            <?php echo $form->error($model, 'text'); ?>
        </div>
        <? if ($reviewsConfig->show_captcha): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode'); ?>
        </div>
        <? endif; ?>

        <div class="row submit">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->

<?php endif; ?>