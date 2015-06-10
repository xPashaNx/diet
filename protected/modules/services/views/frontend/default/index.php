<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView'=>'_view',
        'template'=>"{items}\n{pager}",
        'pager' => array(
            'prevPageLabel'=>'<',
            'nextPageLabel'=>'>',
            'maxButtonCount'=>'10',
            'header'=>'',
        ),
    ));
?>