<?

$cs=Yii::app()->clientScript;
//Подключаем специальный css
$cs->registerCssFile('/css/catalog/admin/catalog_admin.css');

// Подключаем фанси-бокс
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('/js/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.fancybox-1.3.4.css');
$cs->registerScript('images', "
  $('.showPhoto, a[rel=example_group]').fancybox({
		overlayShow: true,
		overlayOpacity: 0.5,
		zoomSpeedIn: 300,
		zoomSpeedOut:300
	});

    $('.showPhoto, a[rel=example_group]').each( function() {
        var alt = $(this).find('img').prop('alt');
        $(this).prop('title',alt);
    });
", CClientScript::POS_READY);

// Показать-скрыть
$cs->registerScript('showhide', "
  $('a.showhide').click(function(){
      if ( $(this).next().css('display') == 'none' ) {
            $(this).next().animate({height: 'show'}, 400);
            $(this).text('Скрыть');
      } else {
            $(this).next().animate({height: 'hide'}, 200);
            $(this).text('Показать');
      }
		return false;
	});
", CClientScript::POS_READY);

// Показать-скрыть (добавление сопутствующих товаров)
$cs->registerScript('shadd', "
  $('a.shadd').click(function(){
      if ( $(this).next().css('display') == 'none' ) {
            $(this).next().animate({height: 'show'}, 400);
      } else {
            $(this).next().animate({height: 'hide'}, 200);
      }
		return false;
	});
", CClientScript::POS_READY);

?>
<h1><?php echo $model->title; ?></h1>
<?echo CHtml::link('Редактировать услугу', array('update', 'id'=>$model->id), array('class'=>'add_element'));?>
<div class="osn_photo">
    <h2>Основное фото</h2>
    <?php
        if($model->photo){
            echo CHtml::link(CHtml::image('/upload/catalog/product/medium/' . $model->photo, $model->title) , array('/upload/catalog/product/' . $model->photo), array('class' => 'showPhoto'));
        } else{echo CHtml::image('/css/catalog/admin/nophoto.jpg', $model->title);}
    ?>
</div>
<div class="dop_photo">
    <h2>Дополнительные фото</h2>
    <?php if (isset($model->catalogImages)):
        foreach ($model->catalogImages as $image) :?>
        <?php echo CHtml::link(CHtml::image('/upload/catalog/product/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/product/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
        <?php
            endforeach;
        endif; ?>
</div>
<div class="clear"></div>
<table class="viewinfo">

    <tr>
        <td><!--Артикул:--></td><td><? //echo $model->article;?></td>
    </tr>
    <tr>
        <td>
            Характеристики:
        </td>
        <td>
            <table class="viewattr">
                <? $attrs=$model->outAttrs(); foreach($attrs as $attr):?>
                 <tr><td class="label"><span><?=$attr['title'];?></span></td>
                     <td>
                         <?
                            if(is_array($attr['value'])){
                                echo implode(', ', $attr['value']);
                            }else{
                               echo $attr['value'];
                            }

                         ?>
                     </td>
                 </tr>
                <?endforeach?>
            </table>
        </td>
    </tr>
    <!--
    <tr>
        <td>Бренд:</td><td><? //echo $model->thisBrand->name;?></td>
    </tr>
    <tr>
        <td>Старая цена:</td><td><? //echo $model->old_price;?></td>
    </tr>
    <tr>
        <td>Цена:</td>
        <td>
            <span class="label">Без ценового профиля:</span> <? //echo $model->outPrice('{price}', 0);?><br/>
            <span class="label">C ценовым профилем:</span> <? //echo $model->outPriceProfiled('{price}', 0);?><br/>
            <span class="label">Отобразится на сайте:</span> <? //echo $model->outPriceCounted(1, '{price}', 0);?><br/>
        </td>
    </tr>
    <tr>
        <td>Ценовой профиль:</td><td><? //echo ($model->thisPriceprofile ? $model->thisPriceprofile->name.' (множитель: '.$model->thisPriceprofile->factor.', коррекция: '.$model->thisPriceprofile->corrector.')' : 'Не применять');?></td>
    </tr>
    -->
    <tr>
        <td>Специальное размещение:</td>
        <td>
            <span class="label">Опубликована:</span> <? echo ($model->on_main ? 'Да' : 'Нет');?><br/>
            <!--
            <span class="label">Хит продаж:</span> <? //echo ($model->hit ? 'Да' : 'Нет');?><br/>
            <span class="label">Рекомендуемый товар:</span> <? //echo ($model->recomended ? 'Да' : 'Нет');?><br/>
            -->
        </td>
    <tr>
        <td>Количество просмотров:</td><td><? echo $model->views;?></td>
    </tr>
</table>

<h3>Описание</h3>
<a href="#" class="showhide">Показать</a>
<div style="display: none;"><?=$model->description;?></div>

