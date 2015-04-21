<div class="categories">
    <div class="category">
    <?php
        if ($data->image)
            echo CHtml::link(CHtml::image('/upload/catalog/category/small/' . $data->image, $data->short_title), '/services/'.$data->link);

        echo CHtml::link($data->short_title, '/services/'.$data->link);
    ?>
    </div>
</div>