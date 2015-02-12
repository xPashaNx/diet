<div class="random_project">
<?if ($projects):?>
	<h2>Наши работы</h2>
	<?foreach ($projects as $project):?>
	<?php
		if ($project->photo != '') {
			echo CHtml::link(CHtml::image('/upload/catalog/product/' . $project->photo, $project->title), $project->fullLink);
		} else {
			echo CHtml::link(CHtml::image('/images/nophoto.jpg', $project->title), $project->fullLink);
		}
							?>
	<p><?php echo CHtml::link($project->title,$project->fullLink); ?></p>
	<br/>
	<?endforeach;?>
	<a href="/catalog" class="all"><span> Все работы</span> &raquo;</a>
<?endif;?>
</div>
<?/*?>
<div class="galleries">
	<h2>Последние фотоотчеты</h2>
	<a href="/gallery" class="all">Все фотоотчеты</a>
	<?foreach($gallerys as $gallery):?>
	<div class="gallery">
	<?$cover=$gallery->getCover();?>
		<div class="image">
		<?	if($cover){
				echo CHtml::link(CHtml::image('/upload/gallery/small/'.$cover->file, $gallery->title), '/gallery/default/view/id/'.$gallery->id);
			} else echo 'Обложка не найдена!';
		?>
		<div class="date"><?=date("d.m.Y",$gallery->date);?></div> 
		</div>
		<? echo CHtml::link($gallery->title, '/gallery/default/view/id/'.$gallery->id);?>
	</div>
	<?endforeach;?>
</div><?*/?>
