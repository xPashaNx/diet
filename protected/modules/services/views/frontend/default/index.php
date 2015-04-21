<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $categoryDataProvider,
        'itemView'=>'_view',
    ));

    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $serviceDataProvider,
        'itemView'=>'_service',
    ));
?>
