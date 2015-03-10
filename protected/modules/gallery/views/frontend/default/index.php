<?php $this->breadcrumbs = array('Галереи',); ?>
<h1 class="left">Галереи</h1>
<div class="galleries">	
	<?php $this->widget('zii.widgets.CListView', array(
		'id' => 'gallery-list',
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
		'template' => '{items}<div class="clear"></div>{pager}',
		'pager' => array(
			'header'=>'',
			'prevPageLabel' => '&nbsp;',
			'nextPageLabel' => '&nbsp;',
			'maxButtonCount'=>'5',
		),
	)); ?>
</div>