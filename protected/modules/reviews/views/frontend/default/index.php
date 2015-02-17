<?php
foreach ($reviews as $review)
{
    echo $review->text.'<br>';
}
echo CHtml::link('Оставить отзыв', array('default/create'), array('class' => 'add_review'));