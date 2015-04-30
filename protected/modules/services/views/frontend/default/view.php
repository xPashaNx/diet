<h1><?php echo $category->short_title;?></h1>
<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<?php if (isset($category->catalogServices)): ?>
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView'=>'_service',
    ));die('stop');
    ?>
<?php endif; ?>
<?php echo $category->text; ?>
