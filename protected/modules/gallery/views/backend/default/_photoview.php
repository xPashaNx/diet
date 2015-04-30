<?php

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

<div class="image_block" data-sort="<?=$data->sort_order?>">
    <div class="image">
        <a href="#" class="thumb">
            <span>
                <?echo CHtml::image('/upload/gallery/small/'.$data->file);?>
            </span>
        </a>
    </div>
    <? echo CHtml::link('', array('default/deletephoto', 'id' => $data->id), array('class' => 'delete'));?>
	<div class="editable" id=<?=$data->id?>><?=$data->alt_text?></div>
	<div class="cover">
	<?php
		if ($data->id == $coverPhotoId):
			echo CHtml::activeRadioButton($data, 'id', array('value' => $data->id, 'uncheckValue' => null, 'checked' => 'checked'));
			echo CHtml::label('Обложка', 'for');
		else:
			echo CHtml::activeRadioButton($data, 'id', array('value' => $data->id, 'uncheckValue' => null, 'checked' => ''));
			echo CHtml::label('Сделать обложкой', 'for');
		endif;
	?>	
	</div>
	<?php
		echo CHtml::link(CHtml::image('/images/admin/sort_up.png'), array('default/sortPhoto', 'galleryId' => $data->gallery_id), array('class' => 'sort-prev'));
		echo '&nbsp';
		echo CHtml::link(CHtml::image('/images/admin/sort_down.png'), array('default/sortPhoto', 'galleryId' => $data->gallery_id), array('class' => 'sort-next'));
	?>
</div>