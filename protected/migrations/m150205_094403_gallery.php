<?php

class m150205_094403_gallery extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("

			CREATE TABLE IF NOT EXISTS `gallery` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `cover_photo_id` int(11) DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
			
			CREATE TABLE IF NOT EXISTS `gallery_config` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `count` int(11) DEFAULT NULL,
			  `display_mode` int(11) DEFAULT NULL,
			  `prev_x` int(11) DEFAULT NULL,
			  `prev_y` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
			
			INSERT INTO `gallery_config` (`id`, `title`, `count`, `display_mode`, `prev_x`, `prev_y`) VALUES
				(1, 'Фотогалереи', '', '', '', '');
			
			CREATE TABLE IF NOT EXISTS `gallery_photo` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `gallery_id` int(11) DEFAULT NULL,
			  `file` varchar(255) DEFAULT NULL,
			  `caption` varchar(255) DEFAULT NULL,
			  `alt_text` varchar(255) DEFAULT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("

			DROP TABLE `gallery`;
			DROP TABLE `gallery_config`;
			DROP TABLE `gallery_photo`;

		")->execute();
	}
}