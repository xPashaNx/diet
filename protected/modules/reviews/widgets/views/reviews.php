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
            <?php foreach ($dataProvider as $review):?>
                <li>
                    <div class ="feedback-item">
                        <h2><?php echo $review->name; ?></h2>
                        <p><?php echo $review->text; ?></p>
                        <a href="/reviews"></a>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <a href="#" class="jcarousel-btns_nav prev">&lsaquo;</a>
    <a href="#" class="jcarousel-btns_nav next">&rsaquo;</a>
</div>



