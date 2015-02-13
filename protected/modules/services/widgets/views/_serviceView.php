<li>
    <? if ($data->photo != '') {
            echo CHtml::link(CHtml::image('/upload/catalog/service/medium/' . $data->photo, $data->title), $data->fullLink);
        } else {
            echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), $data->fullLink);
        }

    ?>
    <h2><? echo CHtml::link($data->title, $data->fullLink);?></h2>
    <div class="decsr"><?=$data->description;?></div>
</li>
