<ul class="objects">
    <?php $this->widget('zii.widgets.CListView', array(
        'id'=>'service-list',
        'dataProvider'=>$dataProvider,
        'template'=>"{items}<div class='cl'></div>{pager}",
        'itemView'=>'_serviceView',
        'emptyText'=>'',
    )); ?>
</ul>

