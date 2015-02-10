<?php

class m150209_142657_banners extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("

			CREATE TABLE IF NOT EXISTS `banners` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `image` varchar(255) DEFAULT NULL,
			  `link` varchar(255) DEFAULT NULL,
			  `code` text DEFAULT NULL,
			  `content_type` int(11) DEFAULT NULL,
			  `views` int(11) DEFAULT NULL,
			  `clicks` int(11) DEFAULT NULL,
			  `notactive` tinyint(1) DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  `bannerarea` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			
			CREATE TABLE IF NOT EXISTS `banner_area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `mode` int(11) DEFAULT NULL,
			  `widget` varchar(255) DEFAULT NULL,
			  `queue` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
			
		")->execute();
		
		mkdir(dirname(__FILE__).'/../../www/upload/banners');
		chmod(dirname(__FILE__).'/../../www/upload/banners', 0777);
	}

	public function down()
	{
		$this->dbConnection->createCommand("

			DROP TABLE IF EXISTS `banners`;
			DROP TABLE IF EXISTS `banner_area`;

		")->execute();
		
		rmdir(dirname(__FILE__).'/../../www/upload/banners');
	}
}