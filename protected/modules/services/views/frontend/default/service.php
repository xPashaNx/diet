<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
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
<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<div class="center">
	<h1><?php if($data->long_title!='') echo $data->long_title; else echo $data->short_title; ?></h1>
	<div class="obj_details">
		<div class="osn_photo">
			<?php if ($data->photo) echo CHtml::link(CHtml::image('/upload/catalog/service/medium/' . $data->photo, $data->short_title) , array('/upload/catalog/service/' . $model->photo), array('rel'=>'example_group')); ?>
		</div>
		<div class="dop_photo">
			<?php if (isset($data->catalogImages)):
				foreach ($data->catalogImages as $image) :?>
					<?php if ($image->image) echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/service/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
				<?php
				endforeach;
			endif; ?>
		</div>
		<div class='clear'></div>
		<?php echo $data->text; ?>
	</div>
</div>

