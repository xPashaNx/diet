<div class="photo-gallery-items-line">
		<?php
			$cover = $data->getCover();
			if ($cover)
				echo CHtml::link(CHtml::image('/upload/gallery/small/'.$cover->file), '/gallery/default/view/id/'.$data->id, array('class' => 'photo-gallery-item'));
			else
				echo 'Обложка не найдена!';
		?>
</div>


