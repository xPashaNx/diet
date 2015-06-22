<?php foreach($services as $service):?>
    <div class="block">
        <div class="service">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$service["id"];?>">
                <img src="../images/bg-service-item.png">
            </a>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('/services/default/view/id/'); echo '/'.$service["id"];?>">
                <h2>
                    <?php echo $service['short_title'];?>
                </h2>
            </a>
            <p>
                <?php echo $service['keywords'];?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
