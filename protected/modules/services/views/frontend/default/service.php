<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('/js/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.fancybox-1.3.4.css');


Yii::app()->clientScript->registerScript('images', "

  $('a[rel=example_group]').fancybox({
		overlayShow: true,
		overlayOpacity: 0.5,
		zoomSpeedIn: 300,
		zoomSpeedOut:300
	});

	$('a[rel=example_group]').each( function() {
		var alt = $(this).find('img').prop('alt');
		$(this).prop('title',alt);
	});

", CClientScript::POS_READY);


?>

<div class="center">
    <h1><?php if($model->long_title!='') echo $model->long_title; else echo $model->short_title; ?></h1>
    <div class="obj_details">
        <div class="osn_photo">
            <?php if ($model->photo) echo CHtml::link(CHtml::image('/upload/catalog/service/medium/' . $model->photo, $model->short_title) , array('/upload/catalog/service/' . $model->photo), array('rel'=>'example_group')); ?>
        </div>
        <div class="dop_photo">
            <?php if (isset($model->catalogImages)):
                foreach ($model->catalogImages as $image) :?>
                <?php if ($image->image) echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/service/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
                <?php
                    endforeach;
                endif; ?>
        </div>
        <div class='clear'></div>
        <?php echo $model->text; ?>
    </div>
</div>

   