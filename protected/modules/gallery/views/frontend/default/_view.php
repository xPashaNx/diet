<div class = "image-block">
		<?php
			$cover = $data->getCover();
			if ($cover)
				echo CHtml::link(CHtml::image('/upload/gallery/small/'.$cover->file, ''), '/gallery/default/view/id/'.$data->id, array('class' => 'photo-gallery-item', 'data-title' => $data->title));
			else
				echo 'Обложка не найдена!';
		?>
</div>


