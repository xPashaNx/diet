<a href="news/"><h1>Новости</h1></a>

<?php foreach($news as $new):?>
    <div class = "news-item">
        <a href="news/default/view/id/<?php echo $new->id; ?>"> <span><?php echo date("d.m.Y", strtotime($new->date)); ?></span></a>
        <a href="news/default/view/id/<?php echo $new->id; ?>"><h2><?php echo $new->title; ?></h2></a>
        <br>
        <p><?php echo $new->annotation; ?></p>
        <a class="link-arrow" href="news/default/view/id/<?php echo $new->id; ?>"></a>
        <div class="clear"></div>
    </div>
<?php endforeach;?>