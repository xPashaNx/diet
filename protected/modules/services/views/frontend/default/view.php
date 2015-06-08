<?php
$this->breadcrumbs = array(
    'Новости' => 'http://corp.plusonecms.ru/services/',
    $model->short_title,
);
?>
<h1><?php echo $model->short_title;?></h1>
<p><?php echo $this->description; ?></p>
<p><?php echo $this->keywords; ?></p>
<!--
<//?php if (isset($category->catalogServices)): ?>
    <//?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView'=>'_service',
    ));die('stop');
    ?>
<//?php endif; ?>
<h1><//?php echo $category->short_title;?></h1> 
<h1><//?php// echo $this->title; ?></h1>
<//?php// echo $category->text; ?>
!-->