<?php
$this->breadcrumbs=array(
	'Управление галереями'=>array('index'),
	$model->title,
);

$cs=Yii::app()->clientScript;
$cs->registerScript('photos',"

	$(document).off('click', 'a.add');
	$(document).on('click', '.addPhoto', function(){
		block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"GalleryPhoto[image][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
	});
	
	$(document).off('click', '.delPhoto');
	$(document).on('click', '.delPhoto', function(){
		block = $(this).parent('p');
		$(block).remove();
	});

", CClientScript::POS_LOAD);

$cs->registerScript('photo_delete', "
	
	$(document).off('click', '#photo-list a.delete');
	$(document).on('click', '#photo-list a.delete', function(){
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

$cs->registerScript('photo_sort', "

	$(document).off('click', '#photo-list a.sort-prev');
	$(document).on('click', '#photo-list a.sort-prev', function(){
		var currentSort = $(this).parents('.image_block').data('sort'),
			sortArr = [];
			
		$('.image_block').each(function(i) {
			sortArr.push($(this).data('sort'));
		});
		for (var i = 0; i < sortArr.length; i++) {
			if ((sortArr[i] == currentSort) && (i != 0)) {
				sortArr[i] = sortArr[i-1];
				sortArr[i-1] = currentSort;
				break;
			}
		}
		$.ajax({
			type: 'POST',
			url: $(this).prop('href'),
			data: {sortArr:sortArr},
			success: function() {
				location.reload();
			},
		});
		return false;
	});
	
	$(document).off('click', '#photo-list a.sort-next');
	$(document).on('click', '#photo-list a.sort-next', function(){
		var currentSort = $(this).parents('.image_block').data('sort'),
			sortArr = [];
		
		$('.image_block').each(function(i) {
			sortArr.push($(this).data('sort'));
		});
		for (var i = 0; i < sortArr.length; i++) {
			if ((sortArr[i] == currentSort) && (i != sortArr.length-1)) {
				sortArr[i] = sortArr[i+1];
				sortArr[i+1] = currentSort;
				break;
			}
		}
		$.ajax({
			type: 'POST',
			url: $(this).prop('href'),
			data: {sortArr:sortArr},
			success: function() {
				location.reload();
			},
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
            'id' => 'photo-list',
            'dataProvider' => $photoDataProvider,
            'itemView' => '_photoview',
            'emptyText' => 'Нет фотографий',
            'template' => '{items}',
			'viewData' => array(
                'coverPhotoId' => $model->cover_photo_id,
            ),
			'sortableAttributes'=>array(
				'sort_order',
			),
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