<li>
    <? if ($data->photo != '') {
            echo CHtml::link(CHtml::image('/upload/catalog/product/medium/' . $data->photo, $data->title), $data->fullLink);//$this->createUrl('product', array('id' => $data->id)));
        } else {
            echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), $data->fullLink); //$this->createUrl('product', array('id' => $data->id)));
        }

    ?>
    <h2><? echo CHtml::link($data->title, $data->fullLink);?></h2>
    <div class="decsr"><?=$data->descr_tag;?></div>
</li>
