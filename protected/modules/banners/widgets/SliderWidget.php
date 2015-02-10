<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.banners.models.*');
Yii::import('application.modules.banners.widgets.BannersWidget');
/*
Класс виджета слайдера

*/
class SliderWidget extends BannersWidget 
{

    public $viewName = 'slider';
    public $itemViewName = '_slide';

}
?>
