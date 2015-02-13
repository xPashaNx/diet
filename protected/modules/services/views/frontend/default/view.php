<h1><?php echo $category->short_title;?></h1>

<?php if (isset($category->catalogServices)): ?>
<div class="services">
    <?php
        foreach($category->catalogServices as $service)
            echo CHtml::link($service->short_title, $service->fullLink);
    ?>
</div>
<?php endif; ?>

<?php echo $category->text; ?>
