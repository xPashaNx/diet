    <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="flash-success">
            <?php echo CHtml::link('', '#', array ('class' => 'close')); ?>
            <h1>СПАСИБО!</h1>
            <div class = "message"><?php  echo Yii::app()->user->getFlash('success');?></div>
        </div>
    <?php else: ?>
        <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'feedback-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation' => false,
            )); ?>

                    <?php echo CHtml::link('', '#', array ('class' => 'close')); ?>

                    <div class="row">
                        <?php echo CHtml::tag('h1', array(), 'Добавление отзыва'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->textField($model, 'name', array('placeholder'=>'Фамилия Имя Отчество')); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>

                    <div class="row">
                        <?php echo $form->textField($model,'email'); ?>
                        <?php echo $form->error($model, 'email'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->textArea($model, 'text', array('placeholder'=>'Текст отзыва')); ?>
                        <?php echo $form->error($model, 'text'); ?>
                    </div>
                    <?php if($captcha): ?>
                        <div class="captcha-inner">
                            <? $this->widget('CCaptcha', array('captchaAction'=>'/reviews/default/captcha', 'buttonLabel'=>''))?>
                            <div class="captcha-code-inner">
                                <?php echo CHtml::activeTextField($model, 'verifyCode', array('id' => 'user-captcha', 'placeholder'=>'Введите код'))?>
                                <?php echo Chtml::link('Получить новый код', '/reviews/default/captcha/refresh/1', array ('id' => 'yw2_button')); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php echo CHtml::submitButton('Отправить', array ('id' => 'submit')); ?>
            <?php $this->endWidget(); ?>
    <?php endif; ?>
