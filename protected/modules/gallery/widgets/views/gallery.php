<h1>фотогалерея</h1>
<?php if ($gallery and $gallery->cover):?>
	<a href="/gallery/default/view/id/<?php echo $gallery->id; ?>" data-title = "<?php echo $gallery->title;?>"><img src="/upload/gallery/medium/<?php echo $gallery->cover->file; ?>"  alt="" /></a>
<?else:?>
	Нет фото!
<?endif?>

