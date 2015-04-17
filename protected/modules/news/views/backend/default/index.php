<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $titleListNews NewsConfig */
/* @var $criteria CDbCriteria */

$this->breadcrumbs = array(
    $titleListNews,
);

if (Yii::app()->user->hasFlash('addNewsImages')):
    ?>
    <div class = "flash-success">
        <?php echo Yii::app()->user->getFlash('addNewsImages'); ?>
    </div>
<?php
endif;

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#news-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1><?php echo $titleListNews ?></h1>

<?php echo CHtml::link('+Добавить новость', Yii::app()->createUrl('news/default/create'), array('class' => 'add_element')) ?>

<br/>
<p>
    Чтобы установить как производить поиск, можно ввести оператор сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) в начале каждого значения для поиска.
</p>

    <?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'news-grid',
    'dataProvider' => $model->search($criteria),
    'filter' => $model,
    'cssFile' => Yii::app()->getBaseUrl(true) . '/css/admin/gridstyles.css',
    'columns' => array(
        array(
            'name' => 'id',
        ),
        array(
            'name' => 'title',
            'value' => 'CHtml::link($data->title, Yii::app()->createUrl("news/default/update", array("id" => $data->id)))',
            'type' => 'raw',
        ),
        array(
            'name' => 'date',
            'value' => 'date("d.m.Y", strtotime($data->date))',
            'type' => 'raw',
        ),
        array(
            'class' => 'CButtonColumn',
            'viewButtonUrl' => 'Yii::app()->createUrl("../news/default/view/", array("id" => $data->id))',
        ),
    ),
));
?>
