<div class="gallery">
	<div class="image">
	<?if ($gallery and $gallery->cover):?>
		<a href="/gallery/default/view/id/<?=$gallery->id?>"><img src="/upload/gallery/medium/<?=$gallery->cover->file?>"  alt="" /></a>
	<?else:?>
		Нет фото!
	<?endif?>
	</div>
	<p><?php echo ($gallery) ? CHtml::link($gallery->title,'/gallery/default/view/id/'.$gallery->id) : ''; ?></p>
	<a href="/gallery" class="all"><span> Все галереи</span> &raquo;</a>			
</div>