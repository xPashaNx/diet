<?$cs=Yii::app()->clientScript;
//Подключаем css и скрипт для карусели
$cs->registerCssFile('/css/skin.css');
$cs->registerScriptFile('/js/jquery.jcarousel.min.js', CClientScript::POS_HEAD);
$cs->registerScript('carousel', "$('#mycarousel').jcarousel();", CClientScript::POS_READY);
$banner='';
?>
<ul id="mycarousel" class="jcarousel-skin-tango">
	<?
	foreach($banners as $banner){
		echo '<li>'.CHtml::link(CHtml::image('/upload/banners/'.$banner->image, $banner->title), $banner->link).'</li>';	
	}
	?>
</ul>
