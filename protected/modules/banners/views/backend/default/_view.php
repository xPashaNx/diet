<div class="view">
	<h3>
        Рекламное место <i><?php echo CHtml::encode($data->title); ?></i>
            <? echo CHtml::link(CHtml::image('/images/admin/edit.png', 'Редактирование'), Yii::app()->createUrl('banners/default/update', array('id'=>$data->id)), array('title'=>'Редактирование'));?>

            <?
                if(empty($data->banners)){
                    echo CHtml::link(CHtml::image('/images/admin/del.png', 'Удаление'), Yii::app()->createUrl('banners/default/delete', array('id'=>$data->id)), array('class'=>'delete_area', 'title'=>'Удаление'));
                } else {
                    echo CHtml::image('/images/admin/del_disable.png', 'Удаление невозможно', array('title'=>'Удаление невозможно'));
                }
            ?>
    </h3>

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?><br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mode')); ?>:</b>
	<?php echo CHtml::encode($data->modes[$data->mode]); ?><br />

	<?php 
	$dataProvider=new CArrayDataProvider($data->banners, array(
			'sort'=>array(
				'defaultOrder'=>'sort_order',
			),
	));

	$this->widget('application.extensions.admingrid.MyGridView', array(
		'id' => 'blocks-grid-'.$data->id,
		'dataProvider' => $dataProvider,
		'cssFile' => Yii::app()->getBaseUrl(true).'/css/admin/gridstyles.css',
		'columns' => array(
			array(
				'name'=>'title',
				'type'=>'raw',
				'header'=>'Баннер',
				'value'=>'CHtml::link($data->title, Yii::app()->createUrl("banners/banners/update", array("id"=>$data->id)))',
			),
			array(          
				'name'=>'notactive',
				'header'=>'Показывается',
				'value'=>'$data->notactive ? "Нет" : "Да"',
			),
			array(
				'name'=>'views',
				'header'=>'Показов',
			),
			array(
				'class'=>'MyButtonColumn',
				'template' => '{update}{delete}',
				'buttons'=>array(
					'update'=>array(
						'visible'=>'true',
						'url'=>'Yii::app()->createUrl("banners/banners/update", array("id"=>$data->id))',
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
					),
					'delete'=>array(
						'visible'=>'true',
						'url'=>'Yii::app()->createUrl("banners/banners/delete", array("id"=>$data->id))',
						'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/del.png',
					),
				),
				'deleteConfirmation'=>'Вы уверены в удалении баннера?',
			),
			array(
				'class'=>'BannersSSortableColumn',
			),
		),
	));

	echo CHtml::link('Добавить баннер', Yii::app()->createUrl('banners/banners/create', array('bannerarea' => $data->id)));
	?>
</div>