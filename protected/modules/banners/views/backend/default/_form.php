<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#bannerareaTitle').syncTranslit({destination: 'slug'});
", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bannerarea-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('id' => 'bannerareaTitle', 'size' => 60,'maxlength' => 255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('id' => 'slug', 'size' => 60,'maxlength' => 255)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'mode'); ?>
		<?php echo $form->dropDownList($model,'mode', $model->modes); ?>
		<?php echo $form->error($model,'mode'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'widget'); ?>
        <?php echo $form->textField($model,'widget',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'widget'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->