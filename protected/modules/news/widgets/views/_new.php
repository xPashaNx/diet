<li>
    <div><span><?= $data->date; ?></span></div>
        <?php echo CHtml::link($data->title, array('/news/default/view', 'id' => $data->id)); ?>
</li><hr/>