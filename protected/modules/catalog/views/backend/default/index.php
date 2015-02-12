<h1><?php echo $category->title;?></h1>
<?if ($category->id==0):?>
<div class="block">
<h2>Список категорий</h2>
<?php 
echo CHtml::link('+ Добавить категорию', array('default/create', 'id'=>$category->id), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$categoryDataProvider,
	//'template'=>"{items}",
	'emptyText'=>'Нет категорий',
	//'filter'=>$model,
	'hideHeader'=>true,
	'columns'=>array(
	/*	array(
			'name'=>'id',
			'filter'=>false,
		),*/
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), array("index", "id"=>$data->id))',
		),
		/*array(
			'header'=>'Подкатегории',
			'type'=>'raw',
			'value'=>'(count($data->childs)>0) ? CHtml::link("Подкатегории(".count($data->childs).")", array("index", "id"=>$data->id))  : "Подкатегорий нет"',
		),*/
		array(
			'class'=>'MyButtonColumn', 
			'template' => '{update}{delete}',
		),
        array(
            'class'=>'application.modules.catalog.components.SSortable.SSortableCatalogCategoryColumn',
        ),
	),
)); 

?>
</div>

<?else:?>
<h2>Список услуг</h2>
<?php
echo CHtml::link('+ Добавить услугу', array('product/create', 'id_category'=>$category->id), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$products->search(),
	'filter'=>$products,
	'emptyText'=>'Нет услуг в данной категории',
	'columns'=>array(
		array(
			'name'=>'id',
			'filter'=>false,
		),
/*		array(
			'name'=>'number',
			'type'=>'raw',
			'filter'=>false,
			'value'=>'CHtml::link(CHtml::encode($data->number), array("catalogProduct/update", "id"=>$data->id))'
		),*/
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), array("product/view", "id"=>$data->id))'
		),
/*		array(
			'name'=>'price',
			'filter'=>false,
			'value'=>'$data->price." руб."'
		),
		array(
			'name'=>'square',
			'filter'=>false,
			'value'=>'$data->square." кв.м."'
		),*/
		array(
			'class'=>'MyButtonColumn',
			'template' => '{update}{delete}',
			'buttons'=>array
			(
				'update' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
					'url'=>'Yii::app()->createUrl("catalog/product/update", array("id" => $data->id))',
				),
				'delete' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/del.png',
					'url'=>'Yii::app()->createUrl("catalog/product/delete", array("id" => $data->id))',
				),
			),

		),
        array(
            'class'=>'application.modules.catalog.components.SSortable.SSortableCatalogColumn',
        ),
	),
)); 

?>
<?endif;?>


