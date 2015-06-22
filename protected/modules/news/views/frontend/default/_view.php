<div class="news-item">
    <a href = "news/default/view/id/<?php echo $data->id; ?>"><span><?php echo date("d.m.Y", strtotime($data->date)); ?></span></a>
        <a href = "news/default/view/id/<?php echo $data->id; ?>"><h2><?php echo $data->title; ?></h2></a>
    <br>
    <p><?php echo $data->annotation; ?></p>
    <a class="link-arrow" href = "news/default/view/id/<?php echo $data->id; ?>"></a>
    <div class="clear"></div>
</div>

