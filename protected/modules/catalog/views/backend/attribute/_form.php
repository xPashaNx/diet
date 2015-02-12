<?
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#attrTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('id'=>'attrTitle', 'size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('id'=>'slug', 'size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_attribute_kind'); ?>
		<?php echo $form->dropDownList($model,'id_attribute_kind',CatalogAttributeKind::getListed()); ?>
		<?php echo $form->error($model,'id_attribute_kind'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'required'); ?>
		<?php //echo $form->checkBox($model,'required'); ?>
		<?php //echo $form->error($model,'required'); ?>
	</div>

    <div class="row">
        <?php $this->widget('application.modules.catalog.components.CategoriesForAttributeForm', array('category'=>$model->use_category));?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->