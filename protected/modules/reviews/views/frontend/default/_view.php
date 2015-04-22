<?php
    echo 'Дата: ' . date('d.m.Y', strtotime($data->date_create)) . '<br>';
    echo 'Имя пользователя: ' . $data->name . '<br>';
    echo 'Текст отзыва: ' . $data->text . '<br><br>';
?>