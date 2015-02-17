<?php

$cs = Yii::app()->clientScript;

$cs->registerScript('check', "

	$(document).off('click', '.check');
	$(document).on('click', '.check', function(){
	    var checkedId = $(this).data('id'),
	        flag = $(this).prop('checked');
        /*$('.items input').each(function(i){
            if ($(this).prop('checked'))
			    checkedIds.push($(this).data('id'));
		});*/
		$.ajax({
			type: 'GET',
			url: 'check/id/'+checkedId+'/flag/'+flag,
		});

		return true;
	});

", CClientScript::POS_READY);

if ($reviews)
{
    if (Yii::app()->user->role == 'admin')
    {
        $this->widget(
            'zii.widgets.grid.CGridView', array(
                'id'           => 'review-grid',
                'dataProvider' => $reviewDataProvider,
                //'emptyText' => 'Нет отзывов',
                //'hideHeader' => true,
                'columns'      => array(
                    array(
                        'type'  => 'raw',
                        'value' => 'CHtml::checkbox("", CHtml::encode($data->checked), array("class" => "check", "data-id" => $data->id))',
                    ),
                    array(
                        'name' => 'name',
                    ),
                    array(
                        'name' => 'email',
                    ),
                    array(
                        'name' => 'text',
                        'type' => 'raw',
                        //'value' => 'text',
                    ),
                    array(
                        'type'  => 'raw',
                        'value' => '($data->public) ? CHtml::link("Скрыть отзыв", array("default/public/id/".$data->id."/flag/0"), array("class" => "hide-review")) : CHtml::link("Опубликовать отзыв", array("default/public/id/".$data->id."/flag/1"), array("class" => "public-review"))',
                    ),
                    array(
                        'class'    => 'CButtonColumn',
                        'template' => '{delete}',
                    ),
                ),
            )
        );
        echo CHtml::link('Выбрать все на странице<br>', array('default/checkAll'), array('class' => 'check-all'));
        /*echo ($review->public) ? CHtml::link('Скрыть отзыв', array('default/public/id/'.$review->id.'/flag/0'), array('class' => 'hide-review')) : CHtml::link('Опубликовать отзыв', array('default/public/id/'.$review->id.'/flag/1'), array('class' => 'public-review'));
        echo CHtml::link('Удалить отзыв', array('default/delete/id/'.$review->id), array('class' => 'del_review'), array('onclick'=>"return confirm('Удалить товар: 123213 ?');"));*/
    }
    else
        foreach ($reviews as $review)
        {
            echo $review->text;
            echo '<br>';
        }
}
else
    echo 'Нет отзывов!<br>';
echo CHtml::link('Оставить отзыв', array('default/create'), array('class' => 'add-review'));