<?php
$this->breadcrumbs = array(
	'Галереи' => array('index'),
    $model->title,
);
$cs=Yii::app()->clientScript;

$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.fancybox-1.3.4.css');
$cs->registerScript('images', "
	$(document).ready(function() {
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
	});
", CClientScript::POS_READY);

?>

<div class="photo-gallery-inner">
	<div class="photo-gallery-items-line">
		<h1><?php echo $model->title;?></h1>
			<?php $this->widget('zii.widgets.CListView', array(
				'id' => 'gallery-list',
				'dataProvider' => $dataProvider,
				'itemView' => '_photoview',
				'template' => '{items}',
			)); ?>
	</div>
</div>