<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */
/* @var $titleListNews NewsConfig */
/* @var $folder_upload News */

$this->breadcrumbs=array(
	$titleListNews,
);
?>

<h1><?php echo $titleListNews ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'viewData' => array(
        'folder_upload' => $folder_upload,
    ),
    'summaryText'=>"",
    'template'=>"{items}\n{pager}",
    'pager' => array(
        'prevPageLabel'=>'<',
        'nextPageLabel'=>'>',
        'maxButtonCount'=>'10',
        'header'=>'',
    ),
)); ?>