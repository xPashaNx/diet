<?php $this->beginContent('//layouts/main_layout'); ?>

    <div class="about-company">
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'o-kompanii')); ?>
    </div>
    <div class="middle-line">
        <h2>Ваши услуги</h2>
        <div class="rope-left"></div>
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'vashi-uslugi-na-glavnoj')); ?>
        <div class="rope-right"></div>
    </div>
    <div class="advantages-line">
        <h2>Преимущества</h2>
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'preimuschestva-na-glavnoj')); ?>
        <img src="images/boat.png" alt="">
    </div>
</div>
<div class="inner">
    <?php echo $content; ?>
    <div class="clear"></div>
	<?$this->widget('application.modules.gallery.widgets.GalleryWidget');?>
    <br/><hr/>
    <div>
        <h3>Вывод виджита "LastNewsWidget":</h3>
        <div>
            <?php $this->widget('application.modules.news.widgets.LastNewsWidget'); ?>
        </div>
    </div>
    <br/><hr/>
</div>
<?php $this->endContent(); ?>