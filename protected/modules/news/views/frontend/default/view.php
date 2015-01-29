<?php
/* @var $this NewsController */
/* @var $model News */
/* @var titleListNews NewsConfig */
/* @var titleBreadcrumbs News */
/* @var $imagesDataProvider NewsImages */

$this->breadcrumbs = array(
    $titleListNews => array('../news'),
    $model->title,
);
?>

<?php
$cs = Yii::app()->clientScript;

// Подключаем фанси-бокс
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
//$cs->registerScriptFile('/js/jquery.mousewheel-3.0.4.pack.js', CClientScript::POS_HEAD);
$cs->registerCssFile('/css/jquery.fancybox-1.3.4.css');
$cs->registerScript('images', "
  $('a[rel=example_group]').fancybox({
		overlayShow: true,
		overlayOpacity: 0.5,
		zoomSpeedIn: 300,
		zoomSpeedOut:300
	});
", CClientScript::POS_READY);
?>

<div class="view_item_news">
    <div class="head_news">
        <h1><?= $model->title; ?></h1>
    </div>
    <div class="img_news">
        <?php if ($model->cover_id == 0 && $model->newsImages): ?>
            <b>
                <?php echo CHtml::image('/upload/userfiles/images/' . $model->newsImages[0]->filename, '', array(
                    'style' => 'width:50%; height:50%; float: left; margin-right: 20px;'));?>
            </b>
        <?php endif ?>

        <?php foreach ($model->newsImages as $image) : ?>
            <?php if ($image->id == $model->cover_id) : ?>
                <b>
                    <?php echo CHtml::image('/upload/userfiles/images/' . $image->filename, '', array(
                        'style' => 'width:50%; height:50%; float: left; margin-right: 20px;'));?>
                </b>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="annotation_news">Аннотация: <?= $model->annotation; ?></div>
    <div class="content_news"><?= $model->description; ?></div>

    <div class="clear"></div>

    <div class="gallery_news">
        <h3>Фотогалерея:</h3>
        <?php $this->widget('zii.widgets.CListView', array(
            'id' => 'gallery-list',
            'dataProvider' => $imagesDataProvider,
            'itemView' => '_photoview',
            'template' => '{items}',
        )); ?>
    </div>

    <hr/>
    <div class="date_news" style="float: right; font-size: 12px;">Дата создания: <?= $model->date; ?></div>
</div>