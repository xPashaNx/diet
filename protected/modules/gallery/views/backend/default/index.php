<?php
$this->breadcrumbs=array(
	'Управление галереями',
);

?>

<h1>Управление галереями</h1>

<?php echo CHtml::link('+ Создать галерею', array('/gallery/default/create'), array('class'=>'add_element')); ?>
<?php $this->widget('application.extensions.admingrid.MyGridView', array(
	'id' => 'gallery-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		'title',
		array(
		    'header' => 'Обложка галереи',
		    'type' => 'raw',
		    'value' => function($data){
				return (isset($data->cover->file)) ? '<img src="/upload/gallery/small/' . $data->cover->file . '">': null;
		    },
        ),
		array(
			'class' => 'MyButtonColumn',
			'template' => '{update}{delete}',
		),
		array(
            'class' => 'application.extensions.SSortable.SSortableColumn',
        ),
	),
)); ?>
