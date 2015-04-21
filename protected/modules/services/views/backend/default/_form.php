<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#productTitle').syncTranslit({destination: 'slug'});
", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'catalog-category-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'short_title'); ?>
		<?php echo $form->textField($model,'short_title',array('size'=>60,'maxlength'=>256, 'id'=>'productTitle')); ?>
		<?php echo $form->error($model,'short_title'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'long_title'); ?>
        <?php echo $form->textField($model,'long_title',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'long_title'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>256, 'id'=>'slug')); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?>
        <?php echo $form->textArea($model, 'keywords', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
        <?php
           if ($model->image)
           {
               echo CHtml::image(Yii::app()->createUrl($model->folder . '/small/' . $model->image));
               echo "<br/> Заменить изображение: ";
            }
        ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

    <div class="row">
        <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                           'model' => $model,
                           'attribute' => 'text',
                           'language' => 'ru',
                           'editorTemplate' => 'full',
        )); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->