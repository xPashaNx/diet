<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/mobilyslider.js', CClientScript::POS_HEAD);
$cs->registerScript('slider', "

	$('.slider').mobilyslider({
		content: '.slider-content', 		// селектор для слайдера
		//children: 'div',					// селектор для дочерних элементов
		transition: 'fade', 				// переходы: horizontal, vertical, fade
		animationSpeed: 300, 				// скорость перехода в миллисекундах
		autoplay: true,
		autoplaySpeed: 3000, 				// время между переходами (миллисекунды)
		pauseOnHover: false, 				// останавливать навигацию при наведении на слайдер: false, true
		bullets: true, 						// генерировать навигацию (true/false, class: sliderBullets)
		arrows: true, 						// генерировать стрелки вперед и назад (true/false, class: sliderArrows)
		arrowsHide: true, 					// показывать стрелки только при наведении
		prev: 'prev', 						// название класса для кнопки назад
		next: 'next', 						// название класса для кнопки вперед
		animationStart: function(){}, 		// вызывать функцию при старте перехода
		animationComplete: function(){} 	// вызывать функцию когда переход завершен
	});

	", CClientScript::POS_READY);
?>

<div class="slider">
	<div class="slider-content">
	<? foreach ($banners as $banner):?>
		<div class="item">
			<img src="<?=$banner->folder?>/<?=$banner->image?>" alt="" />
		</div>
	<? endforeach;?>
	</div>
</div>