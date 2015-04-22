<?php
    $this->breadcrumbs = array(
        'Управление блоками' => array('area/index'),
        'Редактирование блока ' . $model->title,
    );

?>

<h1>Редактирование блока <i><?= $model->title; ?></i></h1>

<?= $this->renderPartial('_form', array('model' => $model)); ?>