<div class="news-item">
    <span><?php echo date("d.m.Y", strtotime($data->date)); ?></span>
    <h2><?php echo $data->title; ?></h2>
    <p><?php echo $data->annotation; ?></p>
    <a href = "news/default/view/id/<?php echo $data->id; ?>"></a>
    <div class="clear"></div>
</div>

