				<div class="block">
						<div class="image">
							<?php
								if ($data->image != '') {
									echo CHtml::link(CHtml::image('/upload/catalog/category/' . $data->image, $data->title), '/catalog/'.$data->link);
								} else {
									//echo CHtml::link(CHtml::image('/images/nophoto.jpg', $data->title), '/catalog/'.$data->link);
								}
							?>
						</div>
						<?php echo CHtml::link($data->title, $data->createUrl('category', array('link'=>$data->link))); ?>
				
					<?php if($data->catalogProducts):?>
					<ul>
					<?php $i=0;foreach ($data->catalogProducts as $product):?>
						<li><?php echo CHtml::link($product->title, $product->fullLink); ?></li>
					<?$i++;if ($i==6) break;endforeach;?>
					</ul>
					<?endif;?>
				</div>