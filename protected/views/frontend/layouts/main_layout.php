<?php
Yii::app()->clientScript->registerScript('show_header_scroll', "
    $(window).scroll(function() {
	    if ($(this).scrollTop() > 293){
	        $('.header-scroll').animate({'top': '0px'},2);
	    }
	    else{
	        $('.header-scroll').stop(true).animate({'top': '-119px'},2);
	    }
	});
", CClientScript::POS_READY);
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        Yii::app()->clientScript
            ->registerScriptFile('/js/jquery.jcarousel.min.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/js/jcarousel.responsive.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/js/responsiveslides.min.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/js/responsiveslides.js', CClientScript::POS_HEAD)
            ->registerCoreScript('jquery')
            ->registerCoreScript('jquery.ui')
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php if ($this->title) echo CHtml::encode($this->title), ' - ', CHtml::encode(Yii::app()->config->sitename); ?></title>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>"/>
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta name="language" content="ru"/>
    <meta name="author" content="<?php echo CHtml::encode(Yii::app()->config->author); ?>"/>
    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css"/>
	<script src="/js/lightbox.min.js"></script>
	<link href="/css/lightbox.css" rel="stylesheet" type="text/css"/>
    <link href="/css/responsiveslides.css" rel="stylesheet" type="text/css">
    <link href="/css/jcarousel.responsive.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div class="header-scroll wrapper-inner">

        <a href=".." class="back"></a>
        <div class="grid"></div>
        <a href="" class="logo">сайт-визитка</a>
        <div class="grid"></div>
        <a href="" class="corp">корпоративный сайт</a>
        <a href="" class="shop">интернет-магазин</a>

        <div class="btn-login-line">
            <span>Протестировать панель администратора</span><a href="/manage">войти</a>
        </div>
    </div>
    <header>
        <div class="top-header">
            <div class="wrapper-inner">
                <div class="left-col">
                    <a href="http://plusonecms.ru" class="header-icon back-home">вернуться на главную</a>
                </div>
                <div class="right-col">
                    <a href="http://viz.plusonecms.ru" class="header-icon visitka">сайт-визитка</a>
                    <a href="http://shop.plusonecms.ru" class="header-icon shop">интернет-магазин</a>
                </div>
            </div>
        </div>
        <div class="middle-header">
            <div class="logo wrapper-inner">
                <a href=".."><?php echo CHtml::encode(Yii::app()->config->sitename); ?><p>демонстрационная версия</p></a>
                <div class="grid"></div>
            </div>
        </div>
    </header>
    <div class="main wrapper-inner">
        <div class="bottom-header-inner">
            <div class="btn-login-line">
                <span>Протестировать панель администратора</span><a href="/manage">войти</a>
            </div>
            <div class="bottom-header">
                <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'zagolovok-v-shapke')); ?>
                <div class="phone">
                    <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'telefony-v-shapke')); ?>
                </div>
            </div>
            <nav>
                <?php $this->widget('application.widgets.OutMenu', array('name' => 'main')); ?>
            </nav>
        </div>
        <div class = "content">
            <?php echo $content; ?>
        </div>
        <div class="bottom-line">
            <div class="left-col">© ООО «Sharkcompany», 2015</div>
            <div class="right-col">
                <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'sotsseti-v-podvale-shablona')); ?>
            </div>
        </div>
        <div class="empty"></div>
    </div>
    <footer>
        <div class="top-foot ">
            <div class="wrapper-inner">
                <p>
                    Весь контент на демонстрационной версии является выдуманным, а все совпадения с реальными
                    организациями - случайны.
                    <br>
                    При разработке ни одна рыба не пострадала.
                </p>
            </div>
        </div>
        <div class="btn-order-line">
            <div class="wrapper-inner">
                <a href="#">заказать</a>
            </div>
        </div>
        <div class="bottom-foot">
            <div class="wrapper-inner">
                <a href="http://plus1dev.ru/" class="left-col">© ООО «Плюс один», 2015</a>
                <div class="right-col">
                    <a href="https://vk.com/plusodin_web" class="socialnet vk" target="_blank"></a>
                    <a href="https://www.facebook.com/plusodin" class="socialnet fb" target="_blank"></a>
                    <a href="https://twitter.com/plusodinn" class="socialnet tw" target="_blank"></a>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>