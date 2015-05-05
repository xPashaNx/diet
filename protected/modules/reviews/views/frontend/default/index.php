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

$cs->registerScript('New Reviews',"
    $(document).on('click', '.feedback-link-form', function(){
        $('#dialog').dialog({
          autoOpen: false,
          modal: true,
          zIndex: 3,
          focus: true,
          resizable: true,
        });

        $.ajax({
			type: 'POST',
			url: 'reviews/default/create',
			cache: false,
            success: function(html){
                 $('#dialog').dialog({ modal: true });
                $('#dialog').dialog('option', 'width', 530);
                $('#dialog').dialog('option', 'height', 530);
                $('#dialog').dialog('option', 'z-index', 3);
                $('#dialog').html(html);

            }
		});

        $('#dialog').dialog('open');
    });



    $(document).on('click', ' .form-feedback .close', function(){
        $('#dialog').dialog('close');
    });

    $(document).on('click', '#submit', function(){
         $.ajax({
			type: 'POST',
			url: 'reviews/default/create',
			data: $('#feedback-form').serialize(),
			cache: false,
            success: function(html){
                $('#dialog').dialog('option', 'width', 530);
                $('#dialog').dialog('option', 'height', 256);
                $('#dialog').html(html);
                $.fn.yiiListView.update('reviews-list',{});
            }
		});

        return false;
    });

", CClientScript::POS_READY);
?>
<div class="feedback-inner">
    <?php if (Yii::app()->user->role == 'admin'): ?>
        <div class="feedback-title">
            <h1><?php echo 'ОТЗЫВЫ' ?></h1>
        </div>

        <?php
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
        ?>

        <?php echo CHtml::link('Выбрать все на странице', array('default/checkAll'), array('class' => 'check-all'));?>
        <?php echo CHtml::link('Очистить все на странице', array('default/clearAll'), array('class' => 'clear-all'));?>
        <?php echo 'Отмеченные: <br>'; ?>
        <?php echo CHtml::link('Скрыть<br>', array('default/publicChecked/flag/0'), array('class' => 'public-checked')); ?>
        <?php echo CHtml::link('Опубликовать<br>', array('default/publicChecked/flag/1'), array('class' => 'hide-checked')); ?>
        <?php echo CHtml::link('Удалить<br>', array('default/deleteChecked'), array('confirm' => 'Вы уверены, что хотите удалить данный элемент?', 'class' => 'delete-checked')); ?>
        <br>
    <?php else: ?>
        <?php if ($reviews): ?>
            <div class="feedback-title">
                <h1><?php echo 'ОТЗЫВЫ' ?></h1>
                <div class="feedback-link-form">
                    ДОБАВИТЬ ОТЗЫВ
                </div>
            </div>
            <div class="feedback-inner">
                <?php
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'reviews-list',
                        'dataProvider' => $reviews,
                        'itemView' => '_view',
                        'summaryText'=>"",
                        'template'=>"{items}\n{pager}",
                        'pager' => array(
                            'prevPageLabel'=>'<',
                            'nextPageLabel'=>'>',
                            'maxButtonCount'=>'10',
                            'header'=>'',
                        ),
                    ));
                ?>
            </div>
        <?php else: ?>
           Нет отзывов!<br>
        <?php endif; ?>

    <div class="form-feedback" id = "dialog">
        <?php $this->renderPartial('_form',array(
            'model'=>$model,
            'captcha' => $captcha,
        )); ?>
    </div><!-- form -->
    <?php endif; ?>



</div>




