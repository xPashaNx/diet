<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $titleListNews NewsConfig */
/* @var $imageModel NewsImages */

$this->breadcrumbs = array(
    $titleListNews,
    'Добавление новости',
);
?>

<?php
Yii::app()->clientScript
    ->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#news-title').syncTranslit({destination: 'news-link'});
    ", CClientScript::POS_READY);
?>

<?php
$cs = Yii::app()->clientScript;
$cs->registerScript('photos', "
  $('.addPhoto').on('click', function() {
	  block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"NewsImages[filename][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
	});
  $('.delPhoto').on('click', function() {
	  block = $(this).parent('p');
		$(block).remove();
	});

", CClientScript::POS_LOAD);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <h1>Добавление новости</h1>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 512, 'id' => 'news-title')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'link'); ?>
        <?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 128, 'id' => 'news-link')); ?>
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
        <?php echo CHtml::activeCheckBox($model,'public'); ?>
        <?php echo $form->error($model, 'public'); ?>
    </div>

    <hr/>
    <div class="row">
        <p class="label">Создание галереи:</p>
        <p class="more_img"><?php echo $form->fileField($imageModel, 'filename[]'); ?><span class="addPhoto">+</span>
        </p>
    </div>
    <hr/>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->