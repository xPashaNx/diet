<?php
/* @var $this NewsController */
/* @var $model News */
/* @var titleConfig NewsConfig */
/* @var titleBreadcrumbs News */

$this->breadcrumbs = array(
    $titleConfig => array('.'),
    $model->title,
);
?>

<div class="view_item_news">
    <div class="head_news">
        <h1><?= $model->title; ?></h1>
    </div>
    <div class="annotation_news">Аннотация: <?= $model->annotation; ?></div>
    <div class="content_news"><?= $model->description; ?></div>
    <hr/>
    <div class="date_news" style="float: right; font-size: 12px;">Дата создания: <?= $model->date; ?></div>
</div>