<?php
Yii::app()->clientScript->registerScript('jcarousel', "
    $(function(){
        $('.jcarousel').jcarousel({
				});
			});
", CClientScript::POS_READY);
?>

<div class="jcarousel-wrapper">
    <div class="jcarousel">
        <ul>
            <?php $i = 1;?>
            <?php foreach ($dataProvider as $review):?>
                <li>
                    <div class ="feedback-item review<?php echo $i % 3?>">
                        <h2><?php echo $review->name; ?></h2>
                        <p><?php echo $review->text; ?></p>
                        <p class="feedback-date"><?php echo date("d.m.Y", strtotime($review->date_create)); ?></p>
                        <a href="/reviews"></a>
                    </div>
                </li>
                <?php $i++;?>
            <?php endforeach;?>
        </ul>
    </div>
    <a href="#" class="jcarousel-btns_nav prev">&lsaquo;</a>
    <a href="#" class="jcarousel-btns_nav next">&rsaquo;</a>
</div>



