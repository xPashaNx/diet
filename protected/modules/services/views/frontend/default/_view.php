<div class="service" data-title = "<?php echo $widget->dataProvider->pagination->offset + $index+1; ?>">
    <h2><?php echo $data["short_title"];?></h2>
    <p> <?php if (isset($data["keywords"])) echo $data["keywords"];?> </p>
	<a href = "<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$data["id"];?>"></a>
</div>