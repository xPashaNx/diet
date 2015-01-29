<div class="image_block"">
<div class="image">
    <a href="#" class="thumb">
            <span>
                <?php echo CHtml::image('/upload/userfiles/images/' . $data->filename); ?>
            </span>
    </a>
</div>
<?php echo CHtml::link('', array(
    'default/deleteimage',
    'id' => $data->id), array('class' => 'delete'));?>

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
