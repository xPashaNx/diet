<?php

class m150416_090337_cms33 extends CDbMigration
{
	public function up()
	{
        $this->dbConnection->createCommand("
            ALTER TABLE `area_block` DROP COLUMN `css_class`
        ;")->execute();
        $this->dbConnection->createCommand("
            DROP TABLE `callback_config`
        ;")->execute();
        $this->dbConnection->createCommand("
            CREATE TABLE IF NOT EXISTS `callback_config` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `email` varchar(255) DEFAULT NULL,
			  `message` text DEFAULT NULL,
			  `verify_code` tinyint(1) DEFAULT 0,
			  `timeout` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8
        ;")->execute();
	}

	public function down()
	{
        $this->dbConnection->createCommand("
            ALTER TABLE `area_block` ADD `css_class` varchar(255) NOT NULL;
        ;")->execute();

        $this->dbConnection->createCommand("
            DROP TABLE `callback_config`
        ;")->execute();

        $this->dbConnection->createCommand("
            CREATE TABLE IF NOT EXISTS `callback_config` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `enabled` tinyint(1) NOT NULL,
                `type` varchar(255) NOT NULL,
                `host` varchar(255) NOT NULL,
                `username` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `port` varchar(255) NOT NULL,
                `encryption` varchar(255) NOT NULL,
                `sender` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
              ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
            INSERT INTO `callback_config` (`id`, `enabled`, `type`, `host`, `username`, `password`, `port`, `encryption`, `sender`) VALUES
              (1, 1, 'php', '', '', '', '', '', 'Сайт Визитка');
      ")->execute();
	}
}