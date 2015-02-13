<?php
Yii::app()->clientScript->registerScriptFile('/js/jquery.jeditable.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('jeditable',"
    $(document).ready(function() {
		$('.editable').editable('CreateAltText', {
			onblur: 'submit',
		});
	});

	$(document).on('click', '.editable', function(){
		$(this).css('border', '0');
	});

	$(document).on('blur', '.editable', function(){
		$(this).css('border', '1px dashed');
	});
", CClientScript::POS_LOAD);

$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#serviceTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);

Yii::app()->clientScript->registerScriptFile('/js/jquery.jeditable.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('jeditable', "
	$(document).ready(function() {
		$('.editable').editable('CreateAltText', {
			onblur: 'submit',
		});
	});

	$(document).on('click', '.editable', function(){
		$(this).css('border', '0');
	});

	$(document).on('blur', '.editable', function(){
		$(this).css('border', '1px dashed');
	});
", CClientScript::POS_READY);

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-service-form',
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CatalogCategory::getListed()); ?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_title'); ?>
		<?php echo $form->textField($model,'short_title',array('size'=>60,'maxlength'=>256, 'id'=>'serviceTitle')); ?>
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
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textArea($model,'keywords', array('rows'=>5)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description', array('rows'=>5)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'photo'); ?>
        <?php
            if ($model->photo)
            echo CHtml::image('/upload/catalog/service/small/'.$model->photo);
        ?>
		<?php echo $form->fileField($model,'photo'); ?>
		<?php echo $form->error($model,'photo'); ?>
	</div>


	<div class="row">
		<p class="label">Дополнительные фото</p>
		<?php
		if($model->catalogImages)
			foreach($model->catalogImages as $image) {
				echo '<div class="image_block">';
				echo '<div class="image"><a href="#" class="thumb"><span>';
				echo CHtml::image('/upload/catalog/service/moreimages/small/'.$image->image);
				echo '</span></a>';
				echo "</div>";
				echo CHtml::link('', array(
                    'image/delete',
                    'id' => $image->id), array(
                        'confirm' => 'Вы уверены в удалении изображения?', 'class' => 'delete'));
                echo '<div class="editable" id='.$image->id.'>'.$image->alt_text.'</div>';
				echo "</div>";
			}
		echo '<div class="clear"></div>';
		?>
		<p class="more_img"><?php echo $form->fileField($serviceImages,'image[]'); ?><span class="addFasad">+</span></p>
	</div>

	<div class="row">
        <h3>Спецразмещение</h3>
        <div class="inlined">
        <?php echo $form->labelEx($model,'on_main'); ?>
        <?php echo $form->checkBox($model,'on_main'); ?>
        <?php echo $form->error($model,'on_main'); ?>
        </div>
        <div class="clear"></div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php $this->widget('application.extensions.ckeditor.CKEditor', array(
				'model' => $model,
				'attribute' => 'text',
				'language' => 'ru',
				'editorTemplate' => 'full',
		)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->