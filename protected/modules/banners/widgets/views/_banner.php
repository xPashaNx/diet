<li>	
	<?php
		if ($data->link)			
			echo CHtml::link(CHtml::image('/'.$data->folder.'/'.$data->image, $data->title),$data->link);
		else 
			echo CHtml::image('/'.$data->folder.'/'.$data->image, $data->title);
	?>
</li>
<?php $data->incViews();?>