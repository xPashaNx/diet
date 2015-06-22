<a href="gallery/"><h1>фотогалерея</h1></a>
<br>
<?php if ($gallery and $gallery->cover):?>
	<a href="/gallery/default/view/id/<?php echo $gallery->id; ?>" data-title = "<?php echo $gallery->title;?>"><img class="link-img" src="/upload/gallery/small/<?php echo $gallery->cover->file; ?>"  alt="" /></a>
<?else:?>
	Нет фото!
<?endif?>

