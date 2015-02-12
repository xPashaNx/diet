<div class="random_project">
	<h2>Наши работы</h2>
	<?php
								if ($project->photo != '') {
									echo CHtml::link(CHtml::image('/upload/catalog/product/' . $project->photo, $project->title), $project->fullLink);
								} else {
									//echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), '/catalog/'.$data->link);
								}
							?>
	<p><?php echo CHtml::link($project->title,$project->fullLink); ?></p>
	<a href="/catalog" class="all"><span> Все работы</span> &raquo;</a>
</div>


