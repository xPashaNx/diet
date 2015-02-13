<?php

$cs=Yii::app()->clientScript;
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
                <?php if ($image->image) echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $model->short_title), '/upload/catalog/service/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
                <?php
                    endforeach;
                endif; ?>
        </div>
        <div class='clear'></div>
        <?php echo $model->text; ?>
    </div>
</div>
<div class="right" style="margin-top:43px;" >
	<div class="random_project" style="text-align:left;">
		<h2>Фотографии</h2>
		<?php if ((isset($model->catalogImages)) && (count($model->catalogImages)>0)):?>
		<?foreach($model->catalogImages as $image):?>
		<div class="image">
		<?php echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/service/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
        </div>
		<br/>
		<?endforeach;?>
		<?elseif(count($model->catalogImages)==0):?>
		<span>нет фотографий</span>
		<!--a href="/gallery" class="all"><span> Все работы</span> &raquo;</a-->
		<?endif;?>
	</div>
</div>

   