<?php
$this->breadcrumbs = array(
	'Галереи' => array('index'),
    $model->title,
);

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