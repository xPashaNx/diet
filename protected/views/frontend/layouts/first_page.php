<?php $this->beginContent('//layouts/main_layout'); ?>

   <div class="banners">
        <div class="banner">
            <?php $this->widget('application.modules.banners.widgets.BannersWidget', array('areaname' => 'header'));?>
	    </div>
   </div>

    <div class="service-line">
        <div class="line-inner">
            <a href="services/"><h1>Услуги компании</h1></a>
            <div class="service-inner">
                <?php $this->widget('application.modules.services.widgets.MainPageServicesWidget'); ?>
            </div>
        </div>
    </div>

    <div class="feedback-line justify">
        <a href="reviews/"><h1>отзывы</h1></a>
        <a href=""><span>ДОБАВИТЬ ОТЗЫВ</span></a>
        <div class="justify"></div>
        <div class="clear"></div>
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