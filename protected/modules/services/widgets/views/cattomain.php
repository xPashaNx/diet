<div class="block">
    <div class="image">
        <?php
            if ($data->image != '')
                echo CHtml::link(CHtml::image('/upload/catalog/category/' . $data->image, $data->short_title), '/services/'.$data->link);
        ?>
    </div>
    <?php echo CHtml::link($data->short_title, $data->createUrl('category', array('link' => $data->link))); ?>
</div>