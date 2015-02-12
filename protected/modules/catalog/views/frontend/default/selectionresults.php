<h1>Результаты подбора товаров</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'id'=>'selected-products-list',
	'dataProvider'=>$dataProvider,
	'template'=>"{items}\n{pager}",
	'itemView'=>'_productview',
)); ?>

