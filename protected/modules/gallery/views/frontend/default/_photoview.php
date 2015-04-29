<div class="image-block">
	<?php echo CHtml::link(CHtml::image('/upload/gallery/small/'.$data->file),array('/upload/gallery/' . $data->file), array('rel' => 'example_group', 'class' => 'photo-gallery-item', 'data-title' => $data->alt_text));?>
</div>