<?php
$this->breadcrumbs = array(
	'Настройки отзывов',
);
?>

<h1>Настройки отзывов</h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php  echo Yii::app()->user->getFlash('success');?>
    </div>


<?php else: ?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'reviewsconfig-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => true,
)); ?>
    <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
	<?php echo $form->errorSummary(array($model)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'premoder'); ?>
        <?php echo $form->checkBox($model,'premoder'); ?>
        <?php echo $form->error($model, 'premoder'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'reviews_perpage'); ?>
        <?php echo $form->textField($model,'reviews_perpage'); ?>
        <?php echo $form->error($model, 'reviews_perpage'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'show_captcha'); ?>
        <?php echo $form->checkBox($model,'show_captcha'); ?>
        <?php echo $form->error($model, 'show_captcha'); ?>
    </div>

    <div class="row submit">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
