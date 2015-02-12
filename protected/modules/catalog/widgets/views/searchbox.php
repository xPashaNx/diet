<?Yii::app()->clientScript->registerScript('searchbox', "

	$( '.slider-range' ).slider({
			range: true,
			min: ".number_format($priceRange['min'], 0, '', '').",
			max: ".number_format($priceRange['max']+1, 0, '', '').",
			values: [ ".number_format($priceRange['min'], 0, '', '').", ".number_format($priceRange['max']+1, 0, '', '')." ],
			slide: function( event, ui ) {
				$( '#amount' ).val(ui.values[ 0 ]);
				$( '#amount2' ).val(ui.values[ 1 ]);
			}
	});
	$( '#amount' ).val( $( '.slider-range' ).slider( 'values', 0 ) );
	$( '#amount2' ).val( $( '.slider-range' ).slider( 'values', 1 ) );

    ", CClientScript::POS_READY);
?>
				<div class="searchbox">
					<div class="searchboxinner">
						<div class="searchcont">
							<div class="blocktitle">Быстрый подбор товаров </div>

                            <?php $fastfindform=$this->beginWidget('CActiveForm', array(
                                'id'=>'fast-find-form',
                                'enableAjaxValidation'=>false,
                                'action'=>'/catalog/default/selection/',
                                'method'=>'get',
                            )); ?>
								<div class="fl">
                                    <? print CHtml::dropDownList('selectionParameters[category]', 0, $category_list, array('class'=>'empty','empty'=>'Все категории')); ?>
									<!--<select name="category" class="empty">
										<option value="" >Выберите картегорию...</option>
										<option value="1" >Унитазы</option>
									</select>--><br/>
                                    <? print CHtml::dropDownList('selectionParameters[brand][]', 0, $brand_list, array('class'=>'empty mt5', 'empty'=>'Все производители')); ?>
									<!--<select name="manuf" class="empty mt5">
										<option value="" >Выберите производителя...</option>
										<option value="1" >СССР</option>
									</select>-->
								</div>
								<div class="fl ml15 w275">
									<input type="submit" class="submit" value="" />
									Цена от <input id="amount" type="text" class="inptext" name="selectionParameters[pricefrom]" value="<?=number_format($priceRange['min'], 0, '', '')?>" /> до <input id="amount2" type="text" class="inptext" name="selectionParameters[priceto]" value="<?=number_format($priceRange['max']+1, 0, '', '')?>"  /> р.
									<div class="slider-range"></div>
								</div>
								<div class="clear"></div>
                            <?php $this->endWidget(); ?>

						</div>
					</div>
				</div>