<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.jeditable.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('jeditable',"
    $(document).ready(function() {
		$('.editable').editable('CreateAltText', {
			onblur: 'submit',
		});
	});

	$(document).on('click', '.editable', function(){
		$(this).css('border', '1px solid');
	});

	$(document).on('blur', '.editable', function(){
		$(this).css('border', '1px dashed');
	});
", CClientScript::POS_LOAD);

$cs->registerScript('photos',"

	$(document).off('click', '.addPhoto');
	$(document).on('click', '.addPhoto', function(){
	    block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"CatalogImage[image][]\"><span class=\"addPhoto\">+</span><span class=\"delPhoto\">&ndash;</span></p>').appendTo(block);
	});

    $(document).off('click', '.delPhoto');
	$(document).on('click', '.delPhoto', function(){
	    block = $(this).parent('p');
		$(block).remove();
	});

", CClientScript::POS_LOAD);

$cs->registerScript('photo_sort', "

	$(document).off('click', '.image_block a.sort-prev');
	$(document).on('click', '.image_block a.sort-prev', function(){
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

	$(document).off('click', '.image_block a.sort-next');
	$(document).on('click', '.image_block a.sort-next', function(){
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
		console.log($(this));
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

$cs->registerScript('translit', "
    $('#serviceTitle').syncTranslit({destination: 'slug'});
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
<!-- выбор категории
	<div class="row">
		<//?php echo $form->labelEx($model,'id_category'); ?>
		<//?php echo $form->dropDownList($model,'id_category',CatalogCategory::getListed()); ?>
		<//?php echo $form->error($model,'id_category'); ?>
	</div>
!-->
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
		<?php if ($model->catalogImages): ?>
			<?php foreach ($model->catalogImages as $image) :?>
				<div class="image_block" data-sort="<?php echo $image->sort_order; ?>">
					<div class="image">
						<a href="#" class="thumb">
							<span>
								<?php echo CHtml::image('/upload/catalog/service/moreimages/small/'.$image->image); ?>
							</span>
						</a>
					</div>
				<?php
					echo CHtml::link(
						CHtml::image("/images/admin/del.png", "Удалить"),
						array(
							'image/delete',
							'id' => $image->id),
						array(
							'confirm' => 'Вы уверены в удалении изображения?',
							'class' => 'delete'
						)
					);
				?>
                <div class='editable' id='<?php echo $image->id; ?>'><?php echo $image->alt_text; ?> </div>
                <?php echo CHtml::link(CHtml::image('/images/admin/sort_up.png'), array('image/sortPhoto', 'serviceId' => $image->id_service), array('class' => 'sort-prev'));?>
                <?php echo '&nbsp'; ?>
					<?php echo CHtml::link(CHtml::image('/images/admin/sort_down.png'), array('image/sortPhoto', 'serviceId' => $image->id_service), array('class' => 'sort-next'));?>
				</div>
			<?php endforeach;?>
		<?php endif; ?>
		<div class="clear"></div>
		<p class="more_img">
			<?php echo $form->fileField($serviceImages,'image[]'); ?>
			<span class="addPhoto">+</span>
		</p>
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

</div>