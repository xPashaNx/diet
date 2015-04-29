<?php
/* @var $this NewsController */
/* @var $model News */
/* @var titleListNews NewsConfig */
/* @var titleBreadcrumbs News */
/* @var $imagesDataProvider NewsImages */
/* @var $folder_upload News */

$this->breadcrumbs = array(
    $titleListNews => array('../news'),
    $model->title,
);
?>

<?php
$cs = Yii::app()->clientScript;

// Подключаем фанси-бокс
$cs->registerScriptFile('/js/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
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


    <h1><?php echo $titleListNews ?></h1>

    <div class="news-item">
        <span><?php echo date("d.m.Y", strtotime($model->date)); ?></span>
        <h2><?php echo $model->title; ?></h2>
        <p><?php echo $model->description; ?></p>
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

<div class="clear"></div>

