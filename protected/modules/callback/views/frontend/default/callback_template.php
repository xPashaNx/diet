<p>Здравствуйте, с сайта <a href="<?php echo $this->createAbsoluteUrl('/');?>">&laquo;<?php echo CHtml::encode(Yii::app()->config->sitename); ?>&raquo;</a> отправлено сообщение.</p>
<p><b><u>Данные отправителя:</u></b></p>
<p><b>Имя:</b> <?php echo $model->name; ?></p>
<p><b>E-mail:</b> <?php echo $model->email; ?></p>
<?php if($model->phone): ?> <p><b>Контактный телефон:</b> <?php echo $model->phone; ?></p> <?php endif; ?>
<p><b>Текст сообщения:</b> <?php echo $model->text; ?></p>
