<?php

Yii::app()->clientScript->registerScriptFile('/js/admin/jquery.jeditable.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('jeditable', "
	$(document).ready(function() {
		$('.editable').editable('CreateAltText', {
			onblur: 'submit',
		});
	});
", CClientScript::POS_READY);

?>

<div class="image_block">
    <div class="image">
        <a href="#" class="thumb">
            <span>
                <?echo CHtml::image('/upload/gallery/small/'.$data->file);?>
            </span>
        </a>
    </div>
    <? echo CHtml::link('', array(
                                        'default/deletephoto',
                                        'id' => $data->id), array('class' => 'delete'));?>
	<div class="editable" id=<?=$data->id?>><?=$data->alt_text?></div>
</div>