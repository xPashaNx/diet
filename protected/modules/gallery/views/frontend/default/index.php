<?php $this->breadcrumbs = array('Фотогалерея',); ?>
<h1>ФОТОГАЛЕРЕЯ</h1>
<div class="photo-gallery-inner">
	<div class="photo-gallery-items-line">
		<?php $this->widget('zii.widgets.CListView', array(
			'id' => 'gallery-list',
			'dataProvider' => $dataProvider,
			'itemView' => '_view',
			'template'=>"{items}\n{pager}",
			'summaryText'=>"",
			'pager' => array(
				'prevPageLabel'=>'<',
				'nextPageLabel'=>'>',
				'maxButtonCount'=>'10',
				'header'=>'',
			),
		)); ?>
	</div>
</div>
<div class="clear"></div>