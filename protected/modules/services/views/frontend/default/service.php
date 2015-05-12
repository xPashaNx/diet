<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<div class="center">
	<h1><?php if($category->long_title!='') echo $category->long_title; else echo $category->short_title; ?></h1>
	<div class="obj_details">
		<div class="osn_photo">
			<?php if ($category->photo) echo CHtml::link(CHtml::image('/upload/catalog/service/medium/' . $category->photo, $category->short_title) , array('/upload/catalog/service/' . $category->photo), array('data-lightbox'=>'roadtrip')); ?>
		</div>
		<div class="dop_photo">
			<?php if (isset($category->catalogImages)):
				foreach ($category->catalogImages as $image) :?>
					<?php if ($image->image) echo CHtml::link(CHtml::image('/upload/catalog/service/moreimages/small/' . $image->image, $image->alt_text), '/upload/catalog/service/moreimages/' . $image->image, array('data-lightbox'=>'roadtrip')); ?>
				<?php
				endforeach;
			endif; ?>
		</div>
		<div class='clear'></div>
		<?php echo $category->text; ?>
	</div>
</div>

