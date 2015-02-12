        <h1><?php echo $category->title;?></h1>

        <?/*php $this->widget('zii.widgets.CListView', array(
            'id'=>'catalog-list',
            'dataProvider'=>$dataProvider,
            'template'=>"{items}\n{pager}",
            'itemView'=>'_view',
            'emptyText'=>'',
        )); */?>
	
    <?php if (isset($category->catalogProducts)): ?>
	<div class="products">
		<ul>
		<?foreach($category->catalogProducts as $product):?>
			<li>
				<? echo CHtml::link($product->title, $product->fullLink);?>
			</li>
		<??>
        <?/*php $this->widget('zii.widgets.CListView', array(
            'id'=>'product-list',
            'dataProvider'=>$productDataProvider,
            'template'=>"{items}<div class='cl'></div>{pager}",
            'itemView'=>'_productview',
            'emptyText'=>'',
        )); */?>
    
		<?endforeach;?>
		</ul>
	</div>
    <?php endif; ?>
	
	<?php echo $category->text; ?>
