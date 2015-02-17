<?php

class m150216_123600_reviews extends CDbMigration
{
    public function up()
    {
        $this->dbConnection->createCommand("

            CREATE TABLE IF NOT EXISTS `reviews_config` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `premoder` tinyint(1) DEFAULT NULL,
			  `reviews_perpage` int(11) DEFAULT NULL,
			  `show_captcha` tinyint(1) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;

			CREATE TABLE IF NOT EXISTS `reviews` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `date_create` datetime DEFAULT NULL,
			  `name` varchar(255) DEFAULT NULL,
			  `email` varchar(255) DEFAULT NULL,
			  `text` text DEFAULT NULL,
			  `public` tinyint(1) DEFAULT NULL,
			  `checked` tinyint(1) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;

			INSERT INTO `reviews_config` (`id`, `premoder`, `reviews_perpage`, `show_captcha`) VALUES
				(1, 0, 10, 0);

		")->execute();
    }

    public function down()
    {
        $this->dbConnection->createCommand("

			DROP TABLE `reviews_config`;
			DROP TABLE `reviews`;

		")->execute();
    }
}