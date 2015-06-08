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
 <h1><?php echo $titleListNews ?></h1>

<div class="news-item-view">
    <span><?php echo date("d.m.Y", strtotime($model->date)); ?></span>
    <h2><?php echo $model->title; ?></h2>
    <p><?php echo $model->description; ?></p>
</div>

<div class="img_news">
    <?php foreach ($model->newsImages as $image) : ?>
        <?php //if ($image->id != $model->cover_id) : ?>
            <b>
                <?php echo CHtml::link(CHtml::image('/upload/userfiles/images/' . $image->filename, '', array('style' => 'width:250px; height:250px; float: left; margin-right: 20px;')), '/upload/userfiles/images/' . $image->filename, array('data-lightbox'=>'roadtrip'));?>
            </b>
        <?php //endif; ?>
    <?php endforeach; ?>
</div>

<div class="clear"></div>

