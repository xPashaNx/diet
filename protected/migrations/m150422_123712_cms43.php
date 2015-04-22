<?php

class m150422_123712_cms43 extends CDbMigration
{
	public function up()
	{
		$sql = "
			DROP TABLE `menu_item`;

			CREATE TABLE IF NOT EXISTS `menu_item` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(128) NOT NULL DEFAULT '',
				`link` varchar(128) NOT NULL DEFAULT '',
				`parent_id` int(11) NOT NULL,
				`menu_id` int(11) unsigned NOT NULL,
				`sort_order` int(11) unsigned NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`),
				KEY `PARENT` (`parent_id`),
				KEY `MENU` (`menu_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			INSERT INTO `menu_item` (`id`, `title`, `link`, `parent_id`, `menu_id`, `sort_order`) VALUES
			(1, 'О компании', '/about', 0, 1, 10),
			(2, 'Услуги', '/service', 0, 1, 20),
			(3, 'Фотогалерея', '/gallery', 0, 1, 30),
			(4, 'Новости', '/gallery', 0, 1, 40),
			(5, 'Отзывы', '/reviews', 0, 1, 50),
			(6, 'Контакты', '/contact', 0, 1, 60);";

		$this->dbConnection->createCommand($sql)->execute();
	}

	public function down()
	{}

}