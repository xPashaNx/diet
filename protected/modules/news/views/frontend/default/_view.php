<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="news">
    <?php if ($data->cover_id == 0 && $data->newsImages): ?>
        <b>
            <?php echo CHtml::link(
                CHtml::image('/upload/userfiles/images/' . $data->newsImages[0]->filename, '', array(
                    'style' => 'width:50%; height:50%; float: left; margin-right: 20px;')),
                Yii::app()->createUrl('news/default/view', array('id' => $data->id)));?>
        </b>
    <?php endif ?>

    <?php foreach ($data->newsImages as $image) : ?>
        <?php if ($image->id == $data->cover_id) : ?>
            <b>
                <?php echo CHtml::link(
                    CHtml::image('/upload/userfiles/images/' . $image->filename, '', array(
                        'style' => 'width:50%; height:50%; float: left; margin-right: 20px;')),
                    Yii::app()->createUrl('news/default/view', array('id' => $data->id)));?>
            </b>
        <?php endif; ?>
    <?php endforeach; ?>

    <b><?php echo CHtml::link($data->title, Yii::app()->createUrl('news/default/view', array('id' => $data->id))); ?></b>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('annotation')); ?>:</b>
    <?php echo CHtml::encode($data->annotation); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br/>

    <div style="clear: both; margin-bottom: 10px;"></div>
    <hr/>
</div>

