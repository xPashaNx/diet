<?
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#bannerTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);

$cs->registerScript('change_content_type', "

    $('.content_type[checked]').each(function(){
        $('.choiceform').css({'display' : 'none'});
        $('#ch'+$(this).val()).css({'display' : 'block'});
    });

    $('.content_type').change(function(){
        $('.choiceform').css({'display' : 'none'});
        $('#ch'+$(this).val()).css({'display' : 'block'});
    });

", CClientScript::POS_READY);
?>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'banners-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('id'=>'bannerTitle', 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('id'=>'slug', 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bannerarea'); ?>
		<?php echo $form->dropDownList($model,'bannerarea', $areaList); ?>
		<?php echo $form->error($model,'bannerarea'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content_type'); ?>
		<?php echo $form->radioButtonList($model,'content_type', $model->content_type_list, array(
			'class' => 'content_type',
			'separator' => '',
		)); ?>
		<?php echo $form->error($model,'content_type'); ?>
	</div>

    <div class="choiceform" id="ch1">
        <div class="row">
            <?php echo $form->labelEx($model,'image'); ?>
            <?php
                if ($model->image)
                echo CHtml::image('/'.$model->folder.'/'.$model->image);
            ?>
            <?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'image'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'link'); ?>
            <?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'link'); ?>
        </div>
    </div>

    <div class="choiceform" id="ch2">
        <div class="row">
            <?php echo $form->labelEx($model,'code'); ?>
            <?php echo $form->textArea($model,'code',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'code'); ?>
        </div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'notactive'); ?>
		<?php echo $form->checkBox($model,'notactive'); ?>
		<?php echo $form->error($model,'notactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->