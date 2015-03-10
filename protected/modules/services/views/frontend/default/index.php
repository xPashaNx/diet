<h1><?php echo $this->title; ?></h1>
<?php echo $this->catalog_config->text; ?>
<div class="categories">
    <?php
        foreach ($categories as $category)
        {
            echo '<div class="category">';
            if ($category->image)
                echo CHtml::link(CHtml::image('/upload/catalog/category/small/' . $category->image, $category->short_title), '/services/'.$category->link);
            echo CHtml::link($category->short_title, '/services/'.$category->link);
            echo '</div>';
        }
    ?>
</div>