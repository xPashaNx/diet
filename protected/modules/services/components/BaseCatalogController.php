<?php

/**
 * Class BaseCatalogController
 */
class BaseCatalogController extends FrontEndController
{
    public $catalog_config;

    public function __construct($id,$module = null)
    {
        parent::__construct($id, $module);
        $this->catalog_config = CatalogConfig::model()->findByPk(1);
    }
}