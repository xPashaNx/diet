<?php $this->beginContent('//layouts/main_layout'); ?>

   <div class="banners">
        <div class="banner">
            <?php $this->widget('application.modules.banners.widgets.BannersWidget', array('areaname' => 'header'));?>
	    </div>
   </div>

    <div class="service-line">
        <div class="line-inner">
            <h1>Услуги компании</h1>
            <div class="service-inner">
                <?php $this->widget('application.widgets.OutAreaWidget', array('name' => 'vashi-uslugi-na-glavnoj')); ?>
            </div>
        </div>
    </div>

    <div class="feedback-line">
        <h1>отзывы</h1>
        <?php $this->widget('application.modules.reviews.widgets.ReviewsWidget'); ?>
    </div>

    <div class = "news-line">
        <div class="photo-gallery">
            <?php $this->widget('application.modules.gallery.widgets.GalleryWidget');?>
        </div>
        <div class="news">
            <?php $this->widget('application.modules.news.widgets.LastNewsWidget'); ?>
        </div>
    </div>

<?php $this->endContent(); ?>