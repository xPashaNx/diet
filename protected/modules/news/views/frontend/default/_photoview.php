<!--<div class="image"">-->
    <?echo CHtml::link(
        CHtml::image('/' . $folder_upload . $data->filename, '', array('style' => 'width:20%; height:20%;')),
        array('/' . $folder_upload . $data->filename), array('rel' => 'example_group'));?>
<!--</div>-->