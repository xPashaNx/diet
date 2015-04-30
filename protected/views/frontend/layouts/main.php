<?php $this->beginContent('//layouts/main_layout'); ?>
<div class="content-line">
	<div class="content-inner">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink' => CHtml::link('Главная','/'),
			'separator' => '<span class = "breadcrumbs separator"> &#9642; </span>',
			'links' => $this->breadcrumbs,
			));
		?>
		<?php echo $content; ?>
		<div class="clear"></div>
	</div>
</div>
<?php $this->endContent(); ?>