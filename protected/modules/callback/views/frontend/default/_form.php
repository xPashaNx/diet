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
//				    var response = $(data);
//				    $('.contact-form').html(response.html());
				    $('.contact-form').html(data);
				},
				error: function(data){
				}
            });
            return false;
        });
    ", CClientScript::POS_READY);
?>
<div class="form-contacts">
    <?php if (Yii::app()->user->hasFlash('callback_message')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('callback_message'); ?>
        </div>
    <?php else: ?>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'review-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); ?>

        <div class="contact-form">
            <h1>Напишите нам</h1>
            <div class="row">
                <?php echo $form->textField($model, 'name', array('placeholder'=>"Фамилия Имя Отчество *")); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="row">
                <?php echo $form->textField($model, 'email', array('placeholder'=>$model->getAttributeLabel('email') . ' *')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="row">
                <?php echo $form->textField($model, 'phone', array('placeholder'=>$model->getAttributeLabel('phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
            <div class="row">
                <?php echo $form->textArea($model, 'text', array('class' => 'txt', 'rows' => 6, 'cols' => 30, 'placeholder'=>$model->getAttributeLabel('text'). ' *')); ?>
                <?php echo $form->error($model, 'text'); ?>
            </div>
            <?php if (extension_loaded('gd') and CallbackConfig::model()->checkCaptchaEnabled()): ?>
                <div class="row captcha">
                    <div id="captcha-block">
                        <? $this->widget('CCaptcha', array('captchaAction'=>'/callback/default/captcha', 'buttonLabel'=>'Обновить картинку'))?>
                    </div>
                    <?php echo CHtml::activeTextField($model, 'verifyCode', array('id' => 'captcha', 'placeholder'=>'Введите код'))?>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php echo CHtml::button('Отправить', array('id'=>'submit', 'class' => 'button', 'name' => 'Send message')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    <?php endif; ?>
</div>
