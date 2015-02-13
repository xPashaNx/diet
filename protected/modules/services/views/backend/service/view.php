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
<h1><?php echo $model->short_title; ?></h1>
<?echo CHtml::link('Редактировать услугу', array('update', 'id'=>$model->id), array('class'=>'add_element'));?>
<div class="osn_photo">
    <h2>Основное фото</h2>
    <?php
        if($model->photo){
            echo CHtml::link(CHtml::image('/upload/catalog/service/medium/' . $model->photo, $model->short_title) , array('/upload/catalog/service/' . $model->photo), array('class' => 'showPhoto'));
        } else{echo CHtml::image('/css/catalog/admin/nophoto.jpg', $model->short_title);}
    ?>
</div>
<div class="dop_photo">
    <h2>Дополнительные фото</h2>
    <?php if (isset($model->catalogImages)):
        foreach ($model->catalogImages as $image) :?>
        <?php echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/service/moreimages/' . $image->image, array('rel' => 'example_group')); ?>
        <?php
            endforeach;
        endif; ?>
</div>
<div class="clear"></div>
<table class="viewinfo">
    <tr>
        <td>Специальное размещение:</td>
        <td>
            <span class="label">Опубликована:</span> <? echo ($model->on_main ? 'Да' : 'Нет');?><br/>
        </td>
    </tr>
</table>

<h3>Описание</h3>
<a href="#" class="showhide">Показать</a>
<div style="display: none;"><?=$model->text;?></div>

