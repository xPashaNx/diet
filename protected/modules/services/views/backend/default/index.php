
<h1><?php echo $category->short_title;?></h1>
<?php if ($category->id == 0):?>
<!-- 
<div class="block">
<h2>Список категорий</h2>
<?php 
/*
echo CHtml::link('+ Добавить категорию', array('default/create', 'id'=>$category->id), array('class'=>'add_element'));

$this->widget('ext.plusone.ExtGridView', array(
	'id' => 'category-grid',
	'dataProvider' => $categoryData->search(),
	'emptyText' => 'Нет категории',
	'columns' => array(
		array(
			'name' => 'id',
			'filter' => false,
		),
		array(
			'name' => 'short_title',
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->short_title), array("index", "id" => $data->id))',
			'filter' => false,
		),
		array(
			'class' => 'ExtButtonColumn',
		),
		array(
			'class'=>'application.extensions.SSortable.SSortableCatalogCategoryColumn',
		),
	),
));
*/
?>
</div>
	<br />

!-->
<div class="block">
	<h2>Список услуг</h2>
	<?php echo CHtml::link('+ Добавить услугу', array('service/create'), array('class'=>'add_element'));?>
	<?php
		$this->widget('ext.plusone.ExtGridView', array(
			'id' => 'services-grid',
			'dataProvider' => $services->getEmptyServices(),
			'emptyText' => 'Нет услуг в данной категории',
			'columns' => array(
				array(
					'name' => 'id',
					'filter' => false,
				),
				array(
					'name' => 'short_title',
					'type' => 'raw',
					'value' => 'CHtml::link(CHtml::encode($data->short_title), array("service/view", "id" => $data->id))',
					'filter' => false,
				),
				array(
					'class' => 'ExtButtonColumn',
					'buttons'=>array(
						'update'=>array(
							'url'=>'Yii::app()->createUrl("services/service/update/", array("id"=>$data->id))',
						),
						'delete'=>array(
							'url'=>'Yii::app()->createUrl("services/service/delete/", array("id"=>$data->id))',
						),
					),
				),
				array(
					'class'=>'application.extensions.SSortable.SSortableCatalogServiceColumn',
				),
			),
		));
	?>
</div>
<?else:?>
<h2>Список услуг</h2>
<?php
	echo CHtml::link('+ Добавить услугу', array('service/create', 'id_category' => $category->id), array('class'=>'add_element'));

	$this->widget('ext.plusone.ExtGridView', array(
		'id' => 'services-grid',
		'dataProvider' => $services->search(),
		'emptyText' => 'Нет услуг в данной категории',
		'columns' => array(
			array(
				'name' => 'id',
				'filter' => false,
			),
			array(
				'name' => 'short_title',
				'type' => 'raw',
				'value' => 'CHtml::link(CHtml::encode($data->short_title), array("service/view", "id" => $data->id))',
				'filter' => false,
			),
			array(
				'class' => 'ExtButtonColumn',
				'buttons'=>array(
					'update'=>array(
						'url'=>'Yii::app()->createUrl("services/service/update/", array("id"=>$data->id))',
					),
					'delete'=>array(
						'url'=>'Yii::app()->createUrl("services/service/delete/", array("id"=>$data->id))',
					),
				),
			),
			array(
				'class'=>'application.extensions.SSortable.SSortableCatalogServiceColumn',
			),
		),
	));
?>
<?endif;?>


