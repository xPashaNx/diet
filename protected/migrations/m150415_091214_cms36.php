<?php

class m150415_091214_cms36 extends CDbMigration
{
	public function up()
	{
        $this->dbConnection->createCommand("

        DROP TABLE `area`;

            CREATE TABLE IF NOT EXISTS `area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

        INSERT INTO `area` (`id`, `name`, `title`) VALUES
        (3, 'telefony-v-shapke', 'Телефоны в шапке'),
        (7, 'preimuschestva-na-glavnoj', 'Преимущества на главной'),
        (8, 'dostupy-na-glavnoj', 'Доступы на главной'),
        (9, 'uslugi-na-glavnoj', 'Услуги на главной'),
        (10, 'sotsseti-v-podvale-shablona', 'Соцсети в подвале шаблона'),
        (11, 'zagolovok-v-shapke', 'Заголовок в шапке'),
        (12, 'o-kompanii', 'О компании'),
        (13, 'vashi-uslugi-na-glavnoj', 'Ваши услуги на главной');

        DROP TABLE `area_block`;

        CREATE TABLE IF NOT EXISTS `area_block` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `area_id` int(11) DEFAULT NULL,
			  `visible` tinyint(1) DEFAULT NULL,
			  `content` text,
			  `view` varchar(255) DEFAULT NULL,
			  `css_class` varchar(255) NOT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `AREA` (`area_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

        INSERT INTO `area_block` (`id`, `name`, `title`, `area_id`, `visible`, `content`, `view`, `css_class`, `sort_order`) VALUES
        (45, 'vozmozhnost-zarekomendovat-sebja-dlja-naibolshego-chisla-potentsialnyh-klientov', 'Возможность зарекомендовать себя для наибольшего числа потенциальных клиентов', 7, 1, '<p>\r\n	Возможность зарекомендовать себя для наибольшего числа потенциальных клиентов</p>\r\n', 'areablocknotitle', '', 270),
        (46, 'sozdanie-progressivnogo-imidzha-dlja-kompanii', 'Создание прогрессивного имиджа для компании', 7, 1, '<p>\r\n	Создание прогрессивного имиджа для компании</p>\r\n', 'areablocknotitle', '', 280),
        (17, 'telefony', 'Телефоны', 3, 1, '<p><span>+7(8412)</span> 25 04 04</p>\r\n<p><span>+7(499)</span> 674 76 44</p>', 'areablocknotitle', '', 10),
        (33, 'vk', 'vk', 10, 1, '<a href=\"#\" class=\"vk\" target=\"_blank\"></a>', 'areablocknotitle', 'vk', 170),
        (34, 'fb', 'fb', 10, 1, '<a href=\"#\" class=\"fb\" target=\"_blank\"></a>', 'areablocknotitle', 'fb', 180),
        (35, 'in', 'in', 10, 1, '<a href=\"#\" class=\"in\" target=\"_blank\"></a>', 'areablocknotitle', 'in', 190),
        (36, 'tw', 'tw', 10, 1, '<a href=\"#\" class=\"tw\" target=\"_blank\"></a>', 'areablocknotitle', 'tw', 200),
        (38, 'fishpangram', 'Fishpangram', 11, 1, '<p>\r\n	Лучшая &ldquo;рыба&rdquo; для вашего бизнеса!</p>\r\n', 'areablock', '', 210),
        (39, 'o-kompanii-fishpangram', 'О компании «Fishpangram»', 12, 1, '<p>\r\n	Компания &laquo;Fishpangram&raquo; создана для того, чтобы вы смогли в полной мере оценить информационное наполнение и функциональные возможности вашего будущего сайта. Созданный визуальный образ и услуги на данной демонстрационной версии компании приведены для примера.</p>\r\n<p>\r\n	Для вашего бизнеса мы разработаем свой индивидуальный дизайн, ориентируясь на деятельность именно вашей компании с использованием предложенного функционала.</p>\r\n', 'areablock', '', 220),
        (40, 'dostavka-korma', 'Доставка корма', 13, 1, '<p>\r\n	Доставка корма</p>\r\n', 'areablocknotitle', 'delivery servis', 230),
        (41, 'uborka-akvariumov', 'Уборка аквариумов', 13, 1, '<p>\r\n	Уборка аквариумов</p>\r\n', 'areablocknotitle', 'cleaning servis', 240),
        (42, 'reklama-rakushek', 'Реклама ракушек', 13, 1, '<p>\r\n	Реклама ракушек</p>\r\n', 'areablocknotitle', 'advertising servis', 250),
        (43, 'vodoroslevoe-obertyvanie', 'Водорослевое обертывание', 13, 1, '<p>\r\n	Водорослевое обертывание</p>\r\n', 'areablocknotitle', 'envelopment servis', 260),
        (47, 'effektivnoe-prodvizhenie-predlagaemyh-uslug', 'Эффективное продвижение предлагаемых услуг', 7, 1, '<p>\r\n	Эффективное продвижение предлагаемых услуг</p>\r\n', 'areablocknotitle', '', 290),
        (48, 'uvelichenie-rynka-sbyta', 'Увеличение рынка сбыта', 7, 1, '<p>\r\n	Увеличение рынка сбыта</p>\r\n', 'areablocknotitle', '', 300),
        (49, 'rasshirenie-geografii-kompanii', 'Расширение географии компании', 7, 1, '<p>\r\n	Расширение географии компании</p>\r\n', 'areablocknotitle', '', 310);

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
        (22, 'О компании', '/about', 0, 1, 80),
        (27, 'Контактная информация', '/contact', 0, 1, 110),
        (29, 'Наполнение сайта', '/content', 0, 1, 90),
        (32, 'Услуги', '/service', 0, 1, 100);

        ")->execute();
	}

	public function down()
	{
        $this->dbConnection->createCommand("

        DROP TABLE `area`;

        CREATE TABLE IF NOT EXISTS `area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

			INSERT INTO `area` (`id`, `name`, `title`) VALUES
			(3, 'telefony-v-shapke', 'Телефоны в шапке'),
			(7, 'preimuschestva-na-glavnoj', 'Преимущества на главной'),
			(8, 'dostupy-na-glavnoj', 'Доступы на главной'),
			(9, 'uslugi-na-glavnoj', 'Услуги на главной'),
			(10, 'sotsseti-v-shapke', 'Соцсети в шапке');

        DROP TABLE `area_block`;

            CREATE TABLE IF NOT EXISTS `area_block` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  `area_id` int(11) DEFAULT NULL,
			  `visible` tinyint(1) DEFAULT NULL,
			  `content` text,
			  `view` varchar(255) DEFAULT NULL,
			  `css_class` varchar(255) NOT NULL,
			  `sort_order` int(11) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `AREA` (`area_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

			INSERT INTO `area_block` (`id`, `name`, `title`, `area_id`, `visible`, `content`, `view`, `css_class`, `sort_order`) VALUES
			(18, 'individualnyj-dizajn', 'Индивидуальный дизайн', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 20),
			(19, 'prostota-upravlenija-sajtom', 'Простота управления сайтом', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 30),
			(17, 'telefony', 'Телефоны', 3, 1, '<div>\r\n	+7(499)674-76-44, +7(8412)250-404</div>\r\n', 'areablocknotitle', '', 10),
			(20, 'vozmozhnost-rasshirenija-funktsionala', 'Возможность расширения  функционала', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit&nbsp;</div>\r\n', 'areablock', '', 40),
			(21, 'garantijnoe-obsluzhivanie', 'Гарантийное обслуживание', 7, 1, '<div>\r\n	Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</div>\r\n', 'areablock', '', 50),
			(22, 'zagolovok', 'Заголовок', 8, 1, '<h2>\r\n	Здесь можно протестировать панель администратора</h2>\r\n', 'areablocknotitle', '', 60),
			(23, 'login-parol', 'Логин-пароль', 8, 1, '<p>\r\n	Логин:&nbsp;<span>demo</span>&nbsp;&nbsp;Пароль:&nbsp;<span>12345</span></p>\r\n', 'areablocknotitle', '', 70),
			(24, 'sovremennyj-dizajn', 'Современный дизайн', 9, 1, '<div>\r\n	Современный дизайн</div>\r\n', 'areablocknotitle', 'design', 80),
			(25, 'panel-administratora', 'Панель администратора', 9, 1, '<div>\r\n	Панель администратора</div>\r\n', 'areablocknotitle', 'panel', 90),
			(26, 'ustanovka-na-rabochij-hosting', 'Установка на рабочий хостинг', 9, 1, '<div>\r\n	Установка на рабочий хостинг</div>\r\n', 'areablocknotitle', 'hosting', 100),
			(27, 'html-verstka', 'HTML - верстка', 9, 1, '<div>\r\n	HTML - верстка</div>\r\n', 'areablocknotitle', 'makeup', 110),
			(28, 'kontent-menedzhment', 'Контент менеджмент', 9, 1, '<div>\r\n	Контент менеджмент</div>\r\n', 'areablocknotitle', 'management', 120),
			(29, 'tehnicheskaja-podderzhka', 'Техническая поддержка', 9, 1, '<div>\r\n	Техническая поддержка</div>\r\n', 'areablocknotitle', 'support', 130),
			(30, 'odnoklassniki', 'Одноклассники', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 140),
			(31, 'odnoklassniki2', 'Одноклассники2', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 150),
			(32, 'odnoklassniki3', 'Одноклассники3', 10, 1, '<a href=\"#\"></a>', 'areablocknotitle', '', 160);

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
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33;

			INSERT INTO `menu_item` (`id`, `title`, `link`, `parent_id`, `menu_id`, `sort_order`) VALUES
				(22, 'О компании', '/about', 0, 1, 80),
			(27, 'Контактная информация', '/contact', 0, 1, 110),
			(28, 'Главная', '/', 0, 1, 20),
			(29, 'Наполнение сайта', '/content', 0, 1, 90),
			(32, 'Услуги', '/service', 0, 1, 100);

        ")->execute();
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}