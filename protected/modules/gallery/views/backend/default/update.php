<?php
$this->breadcrumbs=array(
	'Управление галереями'=>array('index'),
	$model->title,
);

$cs=Yii::app()->clientScript;
$cs->registerScript('photos',"
  $('.addPhoto').live('click', function() {
	  block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"GalleryPhoto[image][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
	});
  $('.delPhoto').live('click', function() {
	  block = $(this).parent('p');
		$(block).remove();
	});

", CClientScript::POS_LOAD);

$cs->registerScript('photo_delete', "
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

?>

<h1><?php echo $model->title; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gallery-form',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<p class="label">Название галереи</p>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
        <?php $this->widget('zii.widgets.CListView', array(
            'id'=>'photo-list',
            'dataProvider'=>$photoDataProvider,
            'itemView'=>'_photoview',
            'emptyText'=>'Нет фотографий',
            'template'=>'{items}',
        )); ?>
        <div class="clear"></div>

        <p class="label">Добавить фото:</p>
		<p class="more_img"><?php echo $form->fileField($photos,'image[]'); ?><span class="addPhoto">+</span></p>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->