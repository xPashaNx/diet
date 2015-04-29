
<div class="h1bg">    <div class="h1pic">
        <h1>Отправка сообщения администрации сайта</h1>
    </div>
</div>
<?php if (!Yii::app()->user->hasFlash('callback_message')): ?>
    <?php $this->renderPartial('_form', array('model' => $model));?>
<?php endif; ?>
