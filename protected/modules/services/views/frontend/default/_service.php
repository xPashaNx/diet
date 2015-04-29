<div class="services">
    <div class="service" ">
        <?php
            if ($data->photo)
            {
                echo CHtml::link(CHtml::image('/upload/catalog/service/small/' . $data->photo, $data->short_title), '/services/'.$data->link);
                echo CHtml::link($data->short_title, $data->fullLink);
            }
        ?>
    </div>
</div>

