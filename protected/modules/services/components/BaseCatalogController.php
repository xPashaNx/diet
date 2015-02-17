<?php

/**
 * Class BaseCatalogController
 */
class BaseCatalogController extends FrontEndController
{
    /**
     * @var catalog config
     */
    public $catalog_config;

    /**
     * Construct
     *
     * @param integer $id
     * @param null $module
     */
    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
        $this->catalog_config = CatalogConfig::model()->findByPk(1);
    }
}