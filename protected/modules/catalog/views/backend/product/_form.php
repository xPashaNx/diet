<?php
Yii::app()->clientScript->registerScript('product',"
  $('.addFasad').live('click', function() {
	  block = $(this).parent('p').parent('div');
		$('<p class=\"more_img\"><input type=\"file\" name=\"CatalogImage[image][]\"><span class=\"addFasad\">+</span><span class=\"delFasad\">&ndash;</span></p>').appendTo(block);
	});
  $('.delFasad').live('click', function() {
	  block = $(this).parent('p');
		$(block).remove();
	});
  $('.addPlan').live('click', function() {
	  number = 0+String(parseInt($(this).prev('input').attr(\"name\").replace('CatalogProductAttribute[0', ''))+1);
	  attr = 0+String(parseInt($(this).prev('input').attr(\"name\").replace('CatalogProductAttribute[0', '')));

	  text = '<div class=\"attribute clear\"><input type=\"hidden\" id=\"kind_'+number+'\" name=\"kind['+number+']\" value=\"14\" \/><input type=\"text\" id=\"CatalogProductAttribute_'+number+'_title\" name=\"CatalogProductAttribute['+number+'][title]\" value=\"\" \/><input type=\"file\" id=\"CatalogProductAttribute_'+number+'_value\" name=\"CatalogProductAttribute['+number+'][value]\" value=\"\" \/><span class=\"addPlan\">+<\/span><span class=\"delPlan\">-<\/span><\/div>';
		$(this).parent('div').after(text);
		$(this).next('span').remove();
		$(this).remove();

	});
  $('.delPlan').live('click', function() {
	  attr = $(this).parent('div').prev('div');
		$('<span class=\"addPlan\">+</span><span class=\"delPlan\">-</span>').appendTo(attr);

	  block = $(this).parent('div');
		$(block).remove();
	});
", CClientScript::POS_LOAD);

$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#productTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);

Yii::app()->clientScript->registerScriptFile('/js/jquery.jeditable.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('jeditable', "
	$(document).ready(function() {
		$('.editable').editable('CreateAltText', {
			onblur: 'submit',
		});
	});

	$(document).on('click', '.editable', function(){
		$(this).css('border', '0');
	});

	$(document).on('blur', '.editable', function(){
		$(this).css('border', '1px dashed');
	});
", CClientScript::POS_READY);

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-product-form',
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>


	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_category'); ?>
		<?php echo $form->dropDownList($model,'id_category',CatalogCategory::getListed()); ?>
		<?php echo $form->error($model,'id_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256, 'id'=>'productTitle')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'long_title'); ?>
		<?php echo $form->textField($model,'long_title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'long_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>256, 'id'=>'slug')); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textArea($model,'keywords', array('rows'=>5)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descr_tag'); ?>
		<?php echo $form->textArea($model,'descr_tag', array('rows'=>5)); ?>
		<?php echo $form->error($model,'descr_tag'); ?>
	</div>

<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'article'); ?>
		<?php //echo $form->textField($model,'article',array('size'=>60,'maxlength'=>256)); ?>
		<?php //echo $form->error($model,'article'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'price'); ?>
		<?php //echo $form->textField($model,'price',array('size'=>60)); ?>
		<?php //echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'currency'); ?>
		<?php //echo $form->dropDownList($model, 'currency', CatalogCurrency::arrayDropList()); ?>
		<?php //echo $form->error($model,'currency'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'priceprofile'); ?>
		<?php //echo $form->dropDownList($model, 'priceprofile', CatalogPriceprofile::arrayDropList(), array('empty'=>'Не применять')); ?>
		<?php //echo $form->error($model,'priceprofile'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'photo'); ?>
        <?php
            if ($model->photo)
            echo CHtml::image('/upload/catalog/product/small/'.$model->photo);
        ?>
		<?php echo $form->fileField($model,'photo'); ?>
		<?php echo $form->error($model,'photo'); ?>
	</div>


	<div class="row">
		<p class="label">Дополнительные фото</p>
		<?php
		if($model->catalogImages)
			foreach($model->catalogImages as $image) {
				echo '<div class="image_block">';
				echo '<div class="image"><a href="#" class="thumb"><span>';
				echo CHtml::image('/upload/catalog/product/moreimages/small/'.$image->image);
				echo '</span></a>';
				echo "</div>";
				echo CHtml::link('', array(
									'image/delete',
									'id' => $image->id), array(
										'confirm' => 'Вы уверены в удалении изображения?', 'class' => 'delete'));
                echo '<div class="editable" id='.$image->id.'>'.$image->alt_text.'</div>';
				echo "</div>";
			}
		echo '<div class="clear"></div>';
		?>
		<p class="more_img"><?php echo $form->fileField($productImages,'image[]'); ?><span class="addFasad">+</span></p>
	</div>

	<div class="row">

        <h3>Спецразмещение</h3>
        <div class="inlined">
        <?php echo $form->labelEx($model,'on_main'); ?>
        <?php echo $form->checkBox($model,'on_main'); ?>
        <?php echo $form->error($model,'on_main'); ?>
        </div>
        <!--
        <div class="inlined">
        <?php //echo $form->labelEx($model,'hit'); ?>
        <?php //echo $form->checkBox($model,'hit'); ?>
        <?php //echo $form->error($model,'hit'); ?>
        </div>
        <div class="inlined">
        <?php //echo $form->labelEx($model,'recomended'); ?>
        <?php //echo $form->checkBox($model,'recomended'); ?>
        <?php //echo $form->error($model,'recomended'); ?>
        </div>
        -->
        <div class="clear"></div>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'views'); ?>
		<?php echo $form->textField($model,'views'); ?>
		<?php echo $form->error($model,'views'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php $this->widget('application.extensions.ckeditor.CKEditor', array(
				'model'=>$model,
				'attribute'=>'description',
				'language'=>'ru',
				'editorTemplate'=>'full',
		)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<?php 
           $this->widget('application.modules.catalog.components.InputAttributesForm', array('productAttributes'=>$model->productAttrubute, 'category'=>$model->idCategory));
    ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->