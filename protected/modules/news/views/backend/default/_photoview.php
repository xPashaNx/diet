<div class="image_block">
    <?php
        echo CHtml::link(
            CHtml::image("/images/admin/del.png", "Удалить"),
            Yii::app()->createUrl('/news/default/deleteImage', array("id" => $data->id)),
            array(
                'id' => $data->id,
                'class' => 'deletePhoto',
            )
        );
    ?>
    <div class="image">
        <a href="<?php echo '/' . $folder_upload . $data->filename; ?>" class="thumb" rel="example_group">
                <span>
                    <?php echo CHtml::image('/' . $folder_upload . $data->filename); ?>
                </span>
        </a>
    </div>

    <?php
    if ($data->id == $cover_id):
        echo CHtml::activeRadioButton($data, 'id', array('value' => $data->id, 'uncheckValue' => null, 'checked' => 'checked'));
        echo CHtml::label('Обложка', 'for');
    else:
        echo CHtml::activeRadioButton($data, 'id', array('value' => $data->id, 'uncheckValue' => null, 'checked' => ''));
        echo CHtml::label('Сделать обложкой', 'for');
    endif;
    ?>
</div>
