<div class="feedback-item">
    <img src = "/images/slider-shark1.png">
    <h2><?php echo $data->name; ?></h2>
    <span class="feedback-item-date"><?php echo 'Дата: ' . date('d.m.Y', strtotime($data->date_create)) . '<br>'; ?></span>
    <p><?php echo $data->text; ?></p>
</div>

