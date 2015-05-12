<div class="image-block">
	<?php echo CHtml::link(CHtml::image('/upload/gallery/small/'.$data->file),array('/upload/gallery/' . $data->file), array('class' => 'photo-gallery-item', 'data-lightbox'=>'roadtrip', 'data-title' => $data->alt_text));?>
</div>