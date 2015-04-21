<?php
$this->breadcrumbs = array(
	'Конфигурация',
);
?>

<h1>Конфигурация</h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php  echo Yii::app()->user->getFlash('success');?>
    </div>


<?php else: ?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'catalogconfig-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation' => true,
)); ?>
    <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
	<?php echo $form->errorSummary(array($model)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
        <?php echo $form->textArea($model, 'keywords', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'layout'); ?>
		<?php echo $form->textField($model,'layout'); ?>
        <?php echo $form->error($model, 'layout'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'category_perpage'); ?>
		<?php echo $form->textField($model,'category_perpage'); ?>
        <?php echo $form->error($model, 'category_perpage'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'service_perpage'); ?>
		<?php echo $form->textField($model,'service_perpage'); ?>
        <?php echo $form->error($model, 'service_perpage'); ?>
	</div>
    <h3>Размеры изображений категорий</h3>
	<div class="row">
		<?php echo $form->labelEx($model,'c_image_small_w'); ?>
		<?php echo $form->textField($model,'c_image_small_w'); ?>
        <?php echo $form->error($model, 'c_image_small_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'c_image_small_h'); ?>
		<?php echo $form->textField($model,'c_image_small_h'); ?>
        <?php echo $form->error($model, 'c_image_small_h'); ?>
	</div>
    <h3>Размеры изображений услуг</h3>
	<div class="row">
		<?php echo $form->labelEx($model,'s_image_middle_w'); ?>
		<?php echo $form->textField($model,'s_image_middle_w'); ?>
        <?php echo $form->error($model, 's_image_middle_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'s_image_middle_h'); ?>
		<?php echo $form->textField($model,'s_image_middle_h'); ?>
        <?php echo $form->error($model, 's_image_middle_h'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'s_image_small_w'); ?>
		<?php echo $form->textField($model,'s_image_small_w'); ?>
        <?php echo $form->error($model, 's_image_small_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'s_image_small_h'); ?>
		<?php echo $form->textField($model,'s_image_small_h'); ?>
        <?php echo $form->error($model, 's_image_small_h'); ?>
	</div>
	<div class="row">
		<h3><?php echo $form->labelEx($model,'resize_mode'); ?></h3>
		<?php echo $form->radioButtonList($model,'resize_mode', $model->arResizeModes); ?>
        <?php echo $form->error($model, 'resize_mode'); ?>
	</div>
    <h3>Водяной знак на изображениях услуг</h3>
    <div class="row">
		<?php echo $form->labelEx($model,'watermark_image'); ?>
        <?php
            if ($model->watermark_image)
            echo CHtml::image('/upload/catalog/service/watermark/'.$model->watermark_image, 'watermark', array('class'=>'watermark_img'));
        ?>
		<?php echo $form->fileField($model,'watermark_image'); ?>
		<?php echo $form->error($model,'watermark_image'); ?>
        <p class="tint">Файл .png</p>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'watermark_x'); ?>
		<?php echo $form->textField($model,'watermark_x'); ?>
        <?php echo $form->error($model, 'watermark_x'); ?>
        <p class="tint">От правого нижнего угла картинки</p>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'watermark_y'); ?>
		<?php echo $form->textField($model,'watermark_y'); ?>
        <?php echo $form->error($model, 'watermark_y'); ?>
        <p class="tint">От правого нижнего угла картинки</p>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'no_watermark'); ?>
		<?php echo $form->checkBox($model,'no_watermark'); ?>
        <?php echo $form->error($model, 'no_watermark'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
             'model' => $model,
             'attribute' => 'text',
             'language' => 'ru',
             'editorTemplate' => 'full',
        )); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>


    <div class="row submit">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
