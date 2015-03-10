<?php
/* @var $this NewsConfigController */
/* @var $model NewsConfig */
/* @var $form CActiveForm */

$this->breadcrumbs = array('Конфигурации');
?>

<?php if (Yii::app()->user->hasFlash('newsConfig')): ?>
<div class = "flash-success">
    <?php echo Yii::app()->user->getFlash('newsConfig'); ?>
</div>
<?php endif; ?>

<h1>Конфигурации</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-config-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'view_count'); ?>
        <?php echo $form->textField($model, 'view_count'); ?>
        <?php echo $form->error($model, 'view_count'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'widget_count'); ?>
        <?php echo $form->textField($model, 'widget_count'); ?>
        <?php echo $form->error($model, 'widget_count'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->