<h1><?php echo $category->short_title;?></h1>

<?php if (isset($category->catalogServices)): ?>
<div class="services">
    <?php
        foreach($category->catalogServices as $service)
        {
            echo '<div class="service">';
            if ($service->photo)
                echo CHtml::link(CHtml::image('/upload/catalog/service/small/' . $service->photo, $service->short_title), '/services/'.$service->link);
            echo CHtml::link($service->short_title, $service->fullLink);
            echo '</div>';
        }
    ?>
</div>
<?php endif; ?>

<?php echo $category->text; ?>
