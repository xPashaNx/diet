<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $titleListNews NewsConfig */
/* @var $imageModel NewsImages */
/* @var $imagesDataProvider NewsImages */
/* @var $folder_upload News */

$this->breadcrumbs = array(
    $titleListNews => array('index'),
    $model->title => array('index', 'id' => $model->id),
    'Редактирование',
);
?>

<?php
Yii::app()->clientScript
    ->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#news-title').syncTranslit({destination: 'news-link'});
    ", CClientScript::POS_READY);

Yii::app()->clientScript
    ->registerScript('photos', "
      $('.addPhoto').live('click', function() {
          block = $(this).parent('p').parent('div');
            $('<p class=\"more_img\"><input type=\"file\" name=\"NewsImages[filename][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
        });
      $('.delPhoto').live('click', function() {
          block = $(this).parent('p');
            $(block).remove();
        });
    ", CClientScript::POS_LOAD);

Yii::app()->clientScript
    ->registerScript('photo_delete', "
        $('#photo-list a.delete').live('click',function() {
            if(!confirm('Вы уверены в удалении фотографии?')) return false;
            var th=this;
            var afterDelete=function(){};
            $.fn.yiiListView.update('photo-list', {
                type:'POST',
                url:$(this).attr('href'),
                success:function(data) {
                    $.fn.yiiListView.update('photo-list');
                    afterDelete(th,true,data);
                },
                error:function(XHR) {
                    return afterDelete(th,false,XHR);
                }
            });
            return false;
        });

    ", CClientScript::POS_READY);

// Подключаем фанси-бокс
Yii::app()->clientScript
    ->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD)
    ->registerCssFile('/css/jquery.fancybox-1.3.4.css')
    ->registerScript('images', "
  $('a[rel=example_group]').fancybox({
		overlayShow: true,
		overlayOpacity: 0.5,
		zoomSpeedIn: 300,
		zoomSpeedOut:300
	});
", CClientScript::POS_READY);
?>



<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <h1>Редактировать: <?php echo $model->title; ?></h1>

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
        <?php echo $form->dropDownList($model, 'public', array(1 => 'Да', 0 => 'Нет')) ?>
        <?php echo $form->error($model, 'public'); ?>
    </div>

    <hr/>
    <div class="row">
        <?php $this->widget('zii.widgets.CListView', array(
            'id' => 'photo-list',
            'dataProvider' => $imagesDataProvider,
            'itemView' => '_photoview',
            'emptyText' => 'Нет фотографий',
            'template' => '{items}',
            'viewData' => array(
                'cover_id' => $model->cover_id,
                'folder_upload' => $folder_upload,
            ),
        )); ?>
        <div class="clear"></div>
        <p class="label">Добавить фото:</p>

        <p class="more_img"><?php echo $form->fileField($imageModel, 'filename[]'); ?><span class="addPhoto">+</span>
        </p>
    </div>
    <hr/>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->