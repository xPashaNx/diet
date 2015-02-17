<?php

/**
 * Class BaseReviewsController
 */
class BaseReviewsController extends FrontEndController
{
    public $reviews_config;

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->reviews_config = ReviewsConfig::model()->findByPk(1);
    }
}