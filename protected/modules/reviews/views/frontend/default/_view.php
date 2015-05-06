<div class="feedback-item">
    <img src = "/images/slider-shark1.png">
    <h2><?php echo $data->name; ?></h2>
    <span class="feedback-item-date"><?php echo 'Дата: ' . date('d.m.Y', strtotime($data->date_create)) . '<br>'; ?></span>
    <p><?php echo $data->text; ?></p>
    <?php if (Yii::app()->user->role == 'admin'): ?>
        <a class="delete" title="Удалить" href="/reviews/default/delete/id/<?php echo $data->id; ?>>">Удалить</a>

        <?php if($data->public): ?>
            <a class="public-review" title="Скрыть отзыв" href="/reviews/default/public/id/<?php echo $data->id; ?>/flag/0>">Скрыть отзыв</a>
        <?php else: ?>
            <a class="public-review" title="Опубликовать" href="/reviews/default/public/id/<?php echo $data->id; ?>/flag/1>">Опубликовать</a>
        <?php endif;?>
    <?php endif; ?>
</div>

