<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/mobilyslider.js', CClientScript::POS_HEAD);
$cs->registerScript('slider', "

	$('.slider').mobilyslider({
		content: '.slider-content',
		transition: 'fade',
		animationSpeed: 300,
		autoplay: true,
		autoplaySpeed: 3000,
		pauseOnHover: true,
		bullets: true,
		arrows: true,
		arrowsHide: true,
		prev: 'prev',
		next: 'next',
		animationStart: function(){},
		animationComplete: function(){}
	});

", CClientScript::POS_READY);
?>

<div class="slider">
	<div class="slider-content">
	<? foreach ($banners as $banner):?>
		<div class="item">
			<img src="<?php echo '/' . $banner->folder . '/' . $banner->image?>" alt="" />
		</div>
	<? endforeach;?>
	</div>
</div>