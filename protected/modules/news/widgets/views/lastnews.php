<h1>Новости</h1>
<?php foreach($news as $new):?>
    <div class = "news-item">
        <span><?php echo date("d.m.Y", strtotime($new->date)); ?></span>
        <h2><?php echo $new->title; ?></h2>
        <p><?php echo $new->annotation; ?></p>
        <a href="#"></a>
        <div class="clear"></div>
    </div>
<?php endforeach;?>