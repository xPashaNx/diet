<?php
$this->breadcrumbs = array(
    'Услуги' => $this->createAbsoluteUrl('/services'),
    $model->short_title,
);
?>
<h1><?php echo $model->short_title;?></h1>
<p><?php echo $this->description; ?></p>
<img style="float: left; margin-top: 15px;" width="260" height="260" src="/upload/catalog/service/<?php echo $this->photo ?>">
<h2><?php echo $this->long_title; ?></h2>
<p><?php echo $this->text; ?></p>

