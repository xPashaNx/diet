<?php

class m150211_145817_catalog extends CDbMigration
{
    public function up()
    {
        $this->dbConnection->createCommand("

            CREATE TABLE IF NOT EXISTS `catalog_config` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `keywords` text DEFAULT NULL,
			  `description` text DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `category_perpage` int(11) DEFAULT NULL,
			  `service_perpage` int(11) DEFAULT NULL,
			  `c_image_small_w` int(11) DEFAULT NULL,
			  `c_image_small_h` int(11) DEFAULT NULL,
			  `s_image_middle_w` int(11) DEFAULT NULL,
			  `s_image_middle_h` int(11) DEFAULT NULL,
			  `s_image_small_w` int(11) DEFAULT NULL,
			  `s_image_small_h` int(11) DEFAULT NULL,
			  `resize_mode` int(11) DEFAULT NULL,
			  `watermark_image` varchar(255) DEFAULT NULL,
			  `watermark_x` int(11) DEFAULT NULL,
			  `watermark_y` int(11) DEFAULT NULL,
			  `no_watermark` bool DEFAULT FALSE,
			  `text` text DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

            INSERT INTO `catalog_config` (`id`, `title`, `keywords`, `description`, `layout`, `category_perpage`, `service_perpage`, `c_image_small_w`, `c_image_small_h`, `s_image_middle_w`, `s_image_middle_h`, `s_image_small_w`, `s_image_small_h`, `resize_mode`, `watermark_image`, `watermark_x`, `watermark_y`, `no_watermark`, `text`) VALUES
				(1, 'Услуги', 'ключевые слова', 'описание', '', 10, 10, 50, 50, 100, 100, 50, 50, 0, '', 10, 10, '', 'текст');

			CREATE TABLE IF NOT EXISTS `catalog_category` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) NOT NULL,
			  `short_title` varchar(100) DEFAULT NULL,
			  `long_title` varchar(255) DEFAULT NULL,
			  `link` varchar(255) DEFAULT NULL,
			  `keywords` text DEFAULT NULL,
			  `description` text DEFAULT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `text` text DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_service` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_category` int(11) NOT NULL,
			  `short_title` varchar(100) DEFAULT NULL,
			  `long_title` varchar(255) DEFAULT NULL,
			  `link` varchar(255) DEFAULT NULL,
			  `keywords` text DEFAULT NULL,
			  `description` text DEFAULT NULL,
			  `photo` varchar(255) DEFAULT NULL,
              `on_main` bool DEFAULT FALSE,
              `text` text DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

			CREATE TABLE IF NOT EXISTS `catalog_image` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `id_service` int(11) NOT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `alt_text` varchar(255) DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

            UPDATE `menu_item` SET `link` = '/services' WHERE `title` = 'Услуги';

		")->execute();

        mkdir(dirname(__FILE__).'/../../www/upload/catalog');
        chmod(dirname(__FILE__).'/../../www/upload/catalog', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/medium');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/medium', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/medium');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/medium', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/small');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/small', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/small');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/small', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/service/watermark');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/service/watermark', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/category');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/category', 0777);

        mkdir(dirname(__FILE__).'/../../www/upload/catalog/category/small');
        chmod(dirname(__FILE__).'/../../www/upload/catalog/category/small', 0777);
    }

    public function down()
    {
        $this->dbConnection->createCommand("

			DROP TABLE IF EXISTS `catalog_config`;
			DROP TABLE IF EXISTS `catalog_category`;
			DROP TABLE IF EXISTS `catalog_service`;
			DROP TABLE IF EXISTS `catalog_image`;

            UPDATE `menu_item` SET `link` = '/service' WHERE `title` = 'Услуги';

		")->execute();

        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/medium');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/medium');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages/small');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/moreimages');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/small');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service/watermark');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/service');

        rmdir(dirname(__FILE__).'/../../www/upload/catalog/category/small');
        rmdir(dirname(__FILE__).'/../../www/upload/catalog/category');

        rmdir(dirname(__FILE__).'/../../www/upload/catalog');
    }
}