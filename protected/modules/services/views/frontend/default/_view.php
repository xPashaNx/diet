<div class="service" data-title = "<?php echo $widget->dataProvider->pagination->offset + $index+1; ?>">
    <a href="<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$data["id"];?>">
        <img src="../images/bg-service-item.png">
    </a>
    <a href="<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$data["id"];?>"><h2><?php echo $data["short_title"];?></h2></a>
    <br>
    <p> <?php if (isset($data["keywords"])) echo $data["keywords"];?> </p>
	<a class="link-arrow" href = "<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$data["id"];?>"></a>
</div>