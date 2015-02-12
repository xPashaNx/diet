<?php

class m150211_145817_catalog extends CDbMigration
{
    public function up()
    {
        $this->dbConnection->createCommand("

            CREATE TABLE IF NOT EXISTS `catalog_config` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `text` text DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `cat_perpage` int(11) DEFAULT NULL,
			  `product_perpage` int(11) DEFAULT NULL,
			  `c_image_small_w` int(11) DEFAULT NULL,
			  `c_image_small_h` int(11) DEFAULT NULL,
			  `p_image_middle_w` int(11) DEFAULT NULL,
			  `p_image_middle_h` int(11) DEFAULT NULL,
			  `p_image_small_w` int(11) DEFAULT NULL,
			  `p_image_small_h` int(11) DEFAULT NULL,
			  `resize_mode` int(11) DEFAULT NULL,
			  `watermark_image` varchar(1000) DEFAULT NULL,
			  `watermark_x` int(11) DEFAULT NULL,
			  `watermark_y` int(11) DEFAULT NULL,
			  `no_watermark` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_category` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` unsigned int(11) NOT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `link` varchar(255) DEFAULT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `text` text DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_attribute` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_attribute_kind` unsigned int(11) NOT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `required` tinyint(1) DEFAULT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_attribute_kind` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_attribute_value` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_attribute` int(11) unsigned NOT NULL,
			  `value` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_category_attribute` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_category` int(11) unsigned NOT NULL,
			  `id_attribute` int(11) unsigned NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_image` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_product` int(11) unsigned NOT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `alt_text` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_product` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_category` int(11) unsigned NOT NULL,
			  `number` varchar(255) DEFAULT NULL,
			  `link` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `long_title` varchar(255) DEFAULT NULL,
			  `keywords` text DEFAULT NULL,
			  `descr_tag` text DEFAULT NULL,
			  `photo` varchar(255) DEFAULT NULL,
			  `description` text DEFAULT NULL,
			  `date_added` int(11) DEFAULT NULL,
			  `on_main` tinyint(1) DEFAULT NULL,
			  `recomended` tinyint(1) DEFAULT NULL,
			  `hit` tinyint(1) DEFAULT NULL,
			  `price` float DEFAULT NULL,
			  `currency` int(11) DEFAULT NULL,
			  `priceprofile` int(11) DEFAULT NULL,
			  `article` varchar(255) DEFAULT NULL,
			  `old_price` float DEFAULT NULL,
			  `views` int(11) DEFAULT NULL,
			  `brand` int(11) DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_product_attribute` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_product` int(11) unsigned NOT NULL,
			  `id_attribute` int(11) unsigned NOT NULL,
			  `value` varchar(255) DEFAULT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

            INSERT INTO `catalog_config` (`id`, `title`, `keywords`, `description`, `text`, `layout`, `cat_perpage`, `product_perpage`, `c_image_small_w`, `c_image_small_h`, `p_image_middle_w`, `p_image_middle_h`, `p_image_small_w`, `p_image_small_h`, `resize_mode`, `watermark_image`, `watermark_x`, `watermark_y`, `no_watermark`) VALUES
				(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

		")->execute();

        mkdir(dirname(__FILE__).'/../../www/upload/catalog');
        chmod(dirname(__FILE__).'/../../www/upload/catalog', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/product');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/product', 0777);
    }

    public function down()
    {
        $this->dbConnection->createCommand("

			DROP TABLE IF EXISTS `catalog_config`;
			DROP TABLE IF EXISTS `catalog_category`;
			DROP TABLE IF EXISTS `catalog_attribute`;
			DROP TABLE IF EXISTS `catalog_attribute_kind`;
			DROP TABLE IF EXISTS `catalog_attribute_value`;
			DROP TABLE IF EXISTS `catalog_category_attribute`;
			DROP TABLE IF EXISTS `catalog_image`;
			DROP TABLE IF EXISTS `catalog_product`;
			DROP TABLE IF EXISTS `catalog_product_attribute`;

		")->execute();

        rmdir(dirname(__FILE__).'/../../www/upload/catalog/product');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog');
    }
}