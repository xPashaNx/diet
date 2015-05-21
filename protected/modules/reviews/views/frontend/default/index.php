<?php
$cs = Yii::app()->clientScript;
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
<?php $this->breadcrumbs = array('Отзывы',); ?>
<div class="feedback-inner">
        <?php if ($reviews): ?>
            <div class="feedback-title">
                <h1><?php echo 'ОТЗЫВЫ' ?></h1>
                <?php if (Yii::app()->user->role != 'admin'): ?>
                    <div class="feedback-link-form">
                        ДОБАВИТЬ ОТЗЫВ
                    </div>
                <?php endif; ?>
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
    </div>
</div>




