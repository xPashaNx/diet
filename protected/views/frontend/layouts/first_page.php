<?php
Yii::app()->clientScript->registerScript('show_header_scroll', "
    $(window).scroll(function() {
	    if ($(this).scrollTop() > 240){
	        $('header').hide();
	        $('.header-scroll').animate({'top': '0px'},0);
	    }
	    else{
	        $('header').show();
	        $('.header-scroll').stop(true).animate({'top': '-119px'},0);
	    }
	});
", CClientScript::POS_READY);
?>

<?php $this->beginContent('//layouts/main_layout'); ?>
    <div class="btn-login-line">
        <span>Протестировать панель администратора</span><a href="/manage">войти</a>
    </div>

    <div class="header-content">
        <div class="left">
            <img src="images/fish.png" alt="" class="fish">
            <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'zagolovok-v-shapke')); ?>
        </div>
        <div class="phone">
            <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'telefony-v-shapke')); ?>
        </div>
    </div>

    <div class="wave-line"></div>

    <nav>
        <?php $this->widget('application.widgets.OutMenu', array('name' => 'main')); ?>
    </nav>

    <div class="about-company">
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'o-kompanii')); ?>
    </div>
    <div class="middle-line">
        <h2>Ваши услуги</h2>

        <div class="roper-left"></div>

        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'vashi-uslugi-na-glavnoj')); ?>

        <div class="roper-right"></div>
    </div>
    <div class="advantages-line">
        <h2>Преимущества</h2>
        <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'preimuschestva-na-glavnoj')); ?>
        <img src="images/boat.png" alt="">
    </div>
    <div class="bottom-line">
        <div class="left-col">© ООО «<span>Fishpangram</span>», 2015</div>
        <div class="right-col">
            <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'sotsseti-v-podvale-shablona')); ?>
        </div>
    </div>

    <div class="inner">
        <?php echo $content; ?>
        <div class="clear"></div>
    </div>
<?php $this->endContent(); ?>