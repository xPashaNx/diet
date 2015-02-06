<?php

$this->breadcrumbs = array(
	'Конфигурация',
);

?>
<h1><?=$model->title?></h1>
<?php if (Yii::app()->user->hasFlash('success')):?>
	<div class="flash-success">
		<?php  echo Yii::app()->user->getFlash('success');?>
	</div>
<?php else: ?>
	<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'gallery-config-form-form',
	)); ?>

		<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->label($model, 'title'); ?>
			<?php echo $form->textField($model, 'title'); ?>
			<?php echo $form->error($model, 'title'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->label($model, 'count'); ?>
			<?php echo $form->textField($model, 'count'); ?>
			<?php echo $form->error($model, 'count'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'display_mode'); ?>
			<?php echo $form->dropDownList($model, 'display_mode', $model->arDisplayMode); ?>
			<?php echo $form->error($model, 'display_mode'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'prev_x'); ?>
			<?php echo $form->textField($model, 'prev_x'); ?>
			<?php echo $form->error($model, 'prev_x'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model, 'prev_y'); ?>
			<?php echo $form->textField($model, 'prev_y'); ?>
			<?php echo $form->error($model, 'prev_y'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Сохранить'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div>
<?php endif; ?>