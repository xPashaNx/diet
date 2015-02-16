<?php $this->beginContent('//layouts/cap'); ?>
<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<?php $this->widget('application.modules.services.widgets.CatalogCatToMainWidget'); ?>
<?php $this->endContent(); ?>