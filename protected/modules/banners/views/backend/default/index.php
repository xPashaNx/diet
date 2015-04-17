
<?php
    $cs=Yii::app()->clientScript;
    $cs->registerScript('bannerarea_delete', "

        $(document).off('click', '#banners-list a.delete_area');
        $(document).on('click', '#banners-list a.delete_area', function(){
            if(!confirm('Вы уверены в удалении рекламного места?')) return false;
            var th=this;
            var afterDelete=function(){};
            $.fn.yiiListView.update('banners-list', {
                type:'POST',
                url:$(this).attr('href'),
                success:function(data) {
                    $.fn.yiiListView.update('banners-list');
                    afterDelete(th,true,data);
                },
                error:function(XHR) {
                    return afterDelete(th,false,XHR);
                }
            });
            return false;
        });

    ", CClientScript::POS_READY);
?>
<?php
$this->breadcrumbs=array(
	'Управление баннерами',
);

?>

<h1>Управление баннерами</h1>
<?echo CHtml::link('+ Добавить рекламное место', array('default/create'), array('class'=>'add_element'));?>
<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'banners-list',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>