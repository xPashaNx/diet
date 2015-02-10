<?php
if (!$typeRotation and $dataProvider->totalItemCount > 1)
{
	$cs = Yii::app()->clientScript;
	$cs->registerScriptFile('/js/tools.js', CClientScript::POS_HEAD);
}
?>
 
<? if ($dataProvider->totalItemCount):?>
<div class="slider">
    <div class="slider-content">
         <? $this->widget('zii.widgets.CListView', array(
			'id' => 'slider',
			'dataProvider' => $dataProvider,
			'template' => "{items}",
			'itemView' => $itemViewName,
			'emptyText' => '',
			'itemsTagName' => 'ul',	
		)); ?>
    </div>
	<div class="slider-ctrl"></div>
</div>
<?endif;?>