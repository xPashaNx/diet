<?php

$cs = Yii::app()->clientScript;

$cs->registerScript('check', "

	$(document).off('click', '.check');
	$(document).on('click', '.check', function(){
	    var checkedId = $(this).data('id'),
	        flag = $(this).prop('checked');

		$.ajax({
			type: 'GET',
			url: 'reviews/default/check/id/'+checkedId+'/flag/'+flag,
		});

		return true;
	});

    $(document).off('click', '.check-all');
	$(document).on('click', '.check-all', function(){
	    var checkedIds = [];
        $('.check').each(function(){
            $(this).attr('checked',true);
            checkedIds.push($(this).data('id'));
        });

        $.ajax({
			type: 'POST',
			url: 'reviews/default/checkAll',
			data: {checkedIds:checkedIds},
			complete: function(){
				$('#review-grid').yiiGridView('update');
			},
		});

        return false;
    });

    $(document).off('click', '.clear-all');
	$(document).on('click', '.clear-all', function(){
	    var checkedIds = [];
        $('.check').each(function(){
            $(this).attr('checked',false);
            checkedIds.push($(this).data('id'));
        });

        $.ajax({
			type: 'POST',
			url: 'reviews/default/clearAll',
			data: {checkedIds:checkedIds},
			complete: function(){
				$('#review-grid').yiiGridView('update');
			},
		});

        return false;
    });

", CClientScript::POS_READY);

if (Yii::app()->user->role == 'admin')
{
    $this->widget(
        'zii.widgets.grid.CGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'type'  => 'raw',
                    'value' => 'CHtml::checkbox("", CHtml::encode(date("d.m.Y", strtotime($data->checked))), array("class" => "check", "data-id" => $data->id))',
                ),
                array(
                    'name' => 'name',
                ),
                array(
                    'name' => 'email',
                ),
                array(
                    'name' => 'text',
                ),
                array(
                    'filter' => $model->arFilter,
                    'name' => 'public',
                    'type' => 'raw',
                    'value' => '($data->public) ? "Опубликован" : "Не опубликован"',
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
    echo CHtml::link('Очистить все на странице<br>', array('default/clearAll'), array('class' => 'clear-all'));
    echo 'Отмеченные: <br>';
    echo CHtml::link('Скрыть<br>', array('default/publicChecked/flag/0'), array('class' => 'public-checked'));
    echo CHtml::link('Опубликовать<br>', array('default/publicChecked/flag/1'), array('class' => 'hide-checked'));
    echo CHtml::link('Удалить<br>', array('default/deleteChecked'), array('confirm' => 'Вы уверены, что хотите удалить данный элемент?', 'class' => 'delete-checked'));
    echo '<br>';
}
else
{
    if ($reviews)
    {
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $reviews,
            'itemView' => '_view',
        ));
    }
    else
        echo 'Нет отзывов!<br>';

    echo CHtml::link('Оставить отзыв', array('default/create'), array('class' => 'add-review'));
}
