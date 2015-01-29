<!--<div class="image"">-->
    <?echo CHtml::link(
        CHtml::image('/upload/userfiles/images/' . $data->filename, '', array('style' => 'width:20%; height:20%;')),
        array('/upload/userfiles/images/' . $data->filename), array('rel' => 'example_group'));?>
<!--</div>-->