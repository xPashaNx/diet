<div class="last_news">
    <h2>Новости</h2>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id' => 'lastnews-list',
        'dataProvider' => $dataProvider,
        'template' => "{items}",
        'itemView' => '_new',
        'itemsTagName' => 'ul',
        'emptyText' => '',
    ));
    ?>
    <a href="/news" class="all"><span> Все новости</span> &raquo;</a>
</div>