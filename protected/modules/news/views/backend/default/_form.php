<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
/* @var $imageModel NewsImages */
?>

<?php
$cs=Yii::app()->clientScript;
$cs->registerScript('photos',"
  $('.addPhoto').live('click', function() {
	  block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"NewsImages[filename][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
	});
  $('.delPhoto').live('click', function() {
	  block = $(this).parent('p');
		$(block).remove();
	});

", CClientScript::POS_LOAD);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions'=>array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php
        echo $form->textField($model, 'title', array(
            'size' => 60,
            'maxlength' => 255,
            'onKeyUp' => "javascript:document.getElementById('news_link').value = translite(this.value);"));
        ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <?= CHtml::scriptFile('/js/admin/news_translit.js') ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'link'); ?>
        <?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 255, 'id' => 'news_link')); ?>
        <?php echo $form->error($model, 'link'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'annotation'); ?>
        <?php echo $form->textField($model, 'annotation', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'annotation'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php
        $this->widget('application.extensions.ckeditor.CKEditor', array(
            'model' => $model,
            'attribute' => 'description',
            'language' => 'ru',
            'editorTemplate' => 'full',
        ));
        ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'meta_keywords'); ?>
        <?php echo $form->textArea($model, 'meta_keywords', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'meta_keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'meta_description'); ?>
        <?php echo $form->textArea($model, 'meta_description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'meta_description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'public'); ?>
        <?php echo $form->dropDownList($model, 'public', array(1 => 'Да', 0 => 'Нет')) ?>
        <?php echo $form->error($model, 'public'); ?>
    </div>

    <hr/>
    <div class="row">
        <p class="label">Создание галереи:</p>
        <p class="more_img"><?php echo $form->fileField($imageModel, 'filename[]'); ?><span class="addPhoto">+</span></p>
    </div>
    <hr/>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->