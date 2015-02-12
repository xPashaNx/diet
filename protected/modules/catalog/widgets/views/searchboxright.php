<?Yii::app()->clientScript->registerScript('searchbox', "

	$( '.slider-range' ).slider({
			range: true,
			min: ".number_format($priceRange['min'], 0, '', '').",
			max: ".number_format($priceRange['max']+1, 0, '', '').",
			values: [ ".$selectionParameters['pricefrom'].", ".$selectionParameters['priceto']." ],
			slide: function( event, ui ) {
				$( '#amount' ).val(ui.values[ 0 ]);
				$( '#amount2' ).val(ui.values[ 1 ]);
			}
	});
	$( '#amount' ).val( $( '.slider-range' ).slider( 'values', 0 ) );
	$( '#amount2' ).val( $( '.slider-range' ).slider( 'values', 1 ) );

	$('.monuf_sw').click(function() {
		var o = $('#'+$(this).attr('rel'));
		var s = o.hasClass('hide');
		if (s) {
			o.removeClass('hide');
			$('span',this).html('&#9660;');
		}
		else {
			o.addClass('hide');

			$('span',this).html('&#9658;');
		}
		return false;
	});
	
    ", CClientScript::POS_READY);
?>


		<div class="topmarket podbor">
			<div class="topmarketinner">
				<div class="topcontainer">
					<div class="blocktitle">Подбор товара</div>
                        <?php $fastfindform=$this->beginWidget('CActiveForm', array(
                            'id'=>'fast-find-form',
                            'enableAjaxValidation'=>false,
                            'action'=>'/catalog/default/selection/',
                            'method'=>'get',
                        )); ?>
                            <? print CHtml::dropDownList('selectionParameters[category]', $selectionParameters['category'], $category_list, array('class'=>'empty','empty'=>'Все категории')); ?>
                            <!--<select name="category" class="empty">
                                <option value="" >Выберите картегорию...</option>
                                <option value="1" >Унитазы</option>
                            </select>-->
                            <div class="bld">Цена</div>
                            от <input id="amount" type="text" class="inptext" name="selectionParameters[pricefrom]" value="<?=$selectionParameters['pricefrom'];?>" /> до <input id="amount2" type="text" class="inptext" name="selectionParameters[priceto]" value="<?=$selectionParameters['priceto'];?>"  /> р.
                            <div class="slider-range"></div>
                            <div class="monuf_sw" rel="manuflist"><span>&#9660;</span><a href="#">Производители </a></div>
                            <div class="monuf" id="manuflist">
                                <ul>
                                    <? foreach($brand_list as $brandid=>$brandname):?>
                                        
                                        <li><? echo CHtml::checkBox('selectionParameters[brand][]', in_array($brandid, $selectionParameters['brand']), array('id'=>'chk'.$brandid, 'value'=>$brandid));?><? echo CHtml::label($brandname, 'chk'.$brandid);?></li>

                                    <?endforeach?>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <?foreach($attributes as $attribite):?>
                                <div class="monuf_sw" rel="<?=$attribite->name;?>"><span>&#9660;</span><a href="#"><?=$attribite->title;?></a></div>
                                <div class="slist" id="<?=$attribite->name;?>">
                                    <ul>
                                        <?foreach($attribite->values as $value):?>
                                            <li><? echo CHtml::checkBox('selectionParameters[attributes]['.$attribite->name.'][]', in_array($value->id, $selectionParameters['attributes'][$attribite->name]), array('id'=>$attribite->name.$value->id, 'value'=>$value->id));?><? echo CHtml::label($value->value, $attribite->name.$value->id);?></li>
                                        <?endforeach?>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            <?endforeach?>
                            <div class="mt15">
                                <!--<a href="#" class="icon pickup ac"></a>-->
                                <input type="submit" class="submit ac" value="" />
                            </div>
                        <?php $this->endWidget(); ?>
					</div>
				</div>
			</div>
			<div class="cartshad"></div>
		</div>