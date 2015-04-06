<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php if ($this->title) echo CHtml::encode($this->title), ' - ', CHtml::encode(Yii::app()->config->sitename); ?></title>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>"/>
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta name="language" content="ru"/>
    <meta name="author" content="<?php echo CHtml::encode(Yii::app()->config->author); ?>"/>
    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<div class="fond"></div>
<div class="wrapper">

    <div class="header-scroll inner">
        <div class="header-line">
            <a href="" class="back"></a>

            <div class="grid"></div>
            <a href="" class="logo">сайт-визитка</a>

            <div class="grid"></div>
            <a href="" class="corp">корпоративный сайт</a>
            <a href="" class="shop">интернет-магазин</a>
        </div>
        <div class="btn-login-line">
            <span>Протестировать панель администратора</span><a href="/manage">войти</a>
        </div>
    </div>

    <header>
        <div class="top-header">
            <div class="inner">
                <div class="left-col">
                    <a href="#">вернуться на главную</a>
                </div>
                <div class="right-col">
                    <a href="#" class="corp">корпоративный сайт</a>
                    <a href="#" class="shop">интернет-магазин</a>
                </div>
            </div>
        </div>
        <div class="middle-header">
            <div class="logo inner">
                <a href="#"><?php echo CHtml::encode(Yii::app()->config->sitename); ?><p>демонстрационная версия</p></a>

                <div class="grid"></div>
            </div>
        </div>
    </header>

    <div class="content inner">
        <?php echo $content; ?>
    </div>

    <footer>
        <div class="top-foot ">
            <div class="inner">
                <p>
                    Весь контент на демонстрационной версии является выдуманным, а все совпадения с реальными
                    организациями - случайны.
                    <br>
                    При разработке ни одна рыба не пострадала.
                </p>
            </div>
        </div>
        <div class="btn-order-line">
            <div class="inner">
                <a href="#">заказать</a>
            </div>
        </div>
        <div class="bottom-foot">
            <div class="inner">
                <a href="http://plus1dev.ru/" class="left-col">© ООО «Плюс один», 2015</a>

                <div class="right-col">
                    <a href="#" class="vk"></a>
                    <a href="#" class="fb"></a>
                    <a href="#" class="in"></a>
                    <a href="#" class="tw"></a>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>