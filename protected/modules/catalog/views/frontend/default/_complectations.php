<?
// Подсчет цены
// Задаем значения по умолчанию для id поля исходной цены и id блока вывда результирующей цены
if(!isset($original_price)){$original_price='original_price';}
if(!isset($pricevalue)){$pricevalue='pricevalue';}
if(!isset($result_price)){$result_price='result_price';}

Yii::app()->clientScript->registerScript('countprice', "
	$('.forcount').change( function() {
	    var val=parseFloat($('#".$original_price."').val().replace(/\s/g, ''));
	    $('.forcount').each(function(i){

	        if($(this).get(0).tagName.toLowerCase()=='select'){
                element=$(this).val();
                title=$(this).find('option[value='+element+']').attr('title');
                if(!title){title='';}
	            sign=title.charAt(0);
	            value=title.substr(1, title.length-1)-0;
	            if(sign=='+') val=val+value;
	            if(sign=='-') val=val-value;
	            if(sign=='=') val=value;
	        } else {
	            if ($(this).get(0).tagName.toLowerCase()=='input' && $(this).attr('checked')) {
	            	sign=$(this).val().charAt(0);
	                value=$(this).val().substr(1, $(this).val().length-1)-0;

                    if(sign=='+') val=val+value;
                    if(sign=='-') val=val-value;
                    if(sign=='=') val=value;
	            }
	        }

	    });
	    $('#".$pricevalue."').text(val);
	    $('#".$result_price."').val(val);

	});

", CClientScript::POS_READY);
?>
<?// Вывод вариантов комплектации
foreach($model->complectations as $complectation):?>
<div class="row">
    <?echo CHtml::label($complectation->title, $complectation->name);?>
    <div>
        <? if($complectation->type==1){
            echo CHtml::checkBox($complectation->name, false, array('class'=>'forcount', 'value'=>$complectation->outCorrSymbol().$complectation->outPriceCorrectionCounted(1,'{price}',0)));
            if($complectation->correction_type>0){echo '  ('.$complectation->outCorrSymbol().$complectation->outPriceCorrectionCounted(1,'{price}',0).')';}
            } else{
                $arrayValueList=$complectation->arrayValuesForList();
                echo CHtml::dropDownList($complectation->name, false, $arrayValueList['values'], array('class'=>'forcount', 'options'=>$arrayValueList['options'], 'empty'=>'Не выбрано'));
            }

        ?>
    </div>

</div>
<?endforeach?>
