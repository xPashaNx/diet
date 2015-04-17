<?php
Yii::app()->clientScript->registerScript("send-message", "
        $(document).off('click', '.button');
        $(document).on('click', '.button', function(){
            $.ajax({
                type: 'POST',
                url: '/callback',
                cache: false,
                async: false,
                data: $('#review-form').serialize(),
				success:function(data) {
				    $('.fotoport').html(data);
				},
				error: function(data){
				}
            });
            //return false;
        });
    ", CClientScript::POS_READY);
?>
<div class="fotoport">
    <?php if (Yii::app()->user->hasFlash('callback_message')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('callback_message'); ?>
        </div>
    <?php else: ?>
    <?php $form = $this->beginWidget('CActiveForm', array(
                          'id' => 'review-form',
                          'htmlOptions' => array('enctype' => 'multipart/form-data'),
                     )); ?>

    <table id="form">
        <tr>
            <td class="form_lable"></td>
            <td class="form_title">
                Все поля обязательны для заполнения
                <?php echo $form->errorSummary($model); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'name'); ?></td>
            <td><?php echo $form->textField($model, 'name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td><?php echo $form->textField($model, 'email'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'phone'); ?></td>
            <td><?php echo $form->textField($model, 'phone'); ?></td>
        </tr>
        <tr>
            <td class="top"><?php echo $form->labelEx($model, 'text'); ?></td>
            <td><?php echo $form->textArea($model, 'text', array('class' => 'txt', 'rows' => 6, 'cols' => 50)); ?></td>
        </tr>
        <?php if (extension_loaded('gd') and CallbackConfig::model()->checkCaptchaEnabled()): ?>
        <tr>
            <td></td>
            <td><? $this->widget('CCaptcha', array('captchaAction'=>'/callback/default/captcha', 'buttonLabel'=>'Обновить картинку'))?></td>
        </tr>
        <tr>

            <td><?=CHtml::activeLabelEx($model, 'verifyCode')?></td>
            <td>

                <?=CHtml::activeTextField($model, 'verifyCode', array('id' => 'captcha'))?>
            </td>

        </tr>
        <?php endif; ?>
        <tr>
            <td></td>
            <td class="button"><?php echo CHtml::button('Отправить сообщение', array('id'=>'send-message', 'name' => 'Send message')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
    <?php endif; ?>
</div>
