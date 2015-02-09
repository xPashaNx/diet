<div class="gallery">
	<div class="image">
	<? 
		$cover = $data->getCover();
		if ($cover)
			echo CHtml::link(CHtml::image('/upload/gallery/medium/'.$cover->file), '/gallery/default/view/id/'.$data->id);
		else 
			echo 'Обложка не найдена!';
	?>
	</div>
	<? echo CHtml::link($data->title,'/gallery/default/view/id/'.$data->id)?>
</div>
