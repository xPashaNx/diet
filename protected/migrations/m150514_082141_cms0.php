<?php

class m150514_082141_cms0 extends CDbMigration
{
	public function up()
	{

		$sql = "
			RENAME TABLE area TO area_old,
						 area_block TO area_block_old,
						 banner_area TO banner_area_old,
						 menu TO menu_old,
						 menu_item TO menu_item_old,
						 page TO page_old;
		";
		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
			CREATE TABLE IF NOT EXISTS `area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) DEFAULT NULL,
			  `title` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

			INSERT INTO `area` (`id`, `name`, `title`) VALUES
			(3, 'telefony-v-shapke', 'Телефоны в шапке'),
			(7, 'preimuschestva-na-glavnoj', 'Преимущества на главной'),
			(8, 'dostupy-na-glavnoj', 'Доступы на главной'),
			(9, 'uslugi-na-glavnoj', 'Услуги на главной'),
			(10, 'sotsseti-v-podvale-shablona', 'Соцсети в подвале шаблона'),
			(11, 'zagolovok-v-shapke', 'Заголовок в шапке'),
			(12, 'o-kompanii', 'О компании'),
			(13, 'vashi-uslugi-na-glavnoj', 'Ваши услуги на главной');";

		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
				CREATE TABLE IF NOT EXISTS `area_block` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) DEFAULT NULL,
				  `title` varchar(255) DEFAULT NULL,
				  `area_id` int(11) DEFAULT NULL,
				  `visible` tinyint(1) DEFAULT NULL,
				  `content` text,
				  `view` varchar(255) DEFAULT NULL,
				  `sort_order` int(11) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  KEY `AREA` (`area_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56;

				INSERT INTO `area_block` (`id`, `name`, `title`, `area_id`, `visible`, `content`, `view`, `sort_order`) VALUES
				(45, 'vozmozhnost-zarekomendovat-sebja-dlja-naibolshego-chisla-potentsialnyh-klientov', 'Возможность зарекомендовать себя для наибольшего числа потенциальных клиентов', 7, 1, '<p>\r\n	Возможность зарекомендовать себя для наибольшего числа потенциальных клиентов</p>\r\n', 'areablocknotitle', 270),
				(46, 'sozdanie-progressivnogo-imidzha-dlja-kompanii', 'Создание прогрессивного имиджа для компании', 7, 1, '<p>\r\n	Создание прогрессивного имиджа для компании</p>\r\n', 'areablocknotitle', 280),
				(17, 'telefony', 'Телефоны', 3, 1, '<a href=\"/\">+7(499) 674 76 44</a>\r\n<a href=\"/\">+7(8412) 25 04 04</a>\r\n', 'areablocknotitle', 10),
				(54, 'vk', 'vk', 10, 1, '<a href = \"#\"  class = \"socialnet vk\"></a>', 'areablocknotitle', 360),
				(55, 'fb', 'fb', 10, 1, '<a href = \"#\"  class = \"socialnet fb\"></a>', 'areablocknotitle', 350),
				(38, 'sharkcompany', 'sharkcompany', 11, 0, '<p>Почувствуй себя акулой бизнеса</p>\r\n', 'areablock', 210),
				(39, 'o-kompanii-fishpangram', 'О компании «Fishpangram»', 12, 1, '<p>\r\n	Компания &laquo;Fishpangram&raquo; создана для того, чтобы вы смогли в полной мере оценить информационное наполнение и функциональные возможности вашего будущего сайта. Созданный визуальный образ и услуги на данной демонстрационной версии компании приведены для примера.</p>\r\n<p>\r\n	Для вашего бизнеса мы разработаем свой индивидуальный дизайн, ориентируясь на деятельность именно вашей компании с использованием предложенного функционала.</p>\r\n', 'areablock', 220),
				(40, 'dostavka-korma', 'Доставка корма', 13, 1, '<div class=\"service\">\r\n<h2>Доставка корма</h2>\r\n\r\n<p>Доставка корма</p>\r\n</div>\r\n', 'areablocknotitle', 240),
				(41, 'uborka-akvariumov', 'Уборка аквариумов', 13, 1, '<div class=\"service\">\r\n<h2>Уборка</h2>\r\n\r\n<p>Уборка аквариумов</p>\r\n</div>\r\n', 'areablocknotitle', 230),
				(42, 'reklama-rakushek', 'Реклама ракушек', 13, 1, '<div class=\"service\">\r\n<h2>Реклама ракушек</h2>\r\n\r\n<p>Реклама ракушек</p>\r\n</div>\r\n', 'areablocknotitle', 250),
				(43, 'vodoroslevoe-obertyvanie', 'Водорослевое обертывание', 13, 1, '<div class=\"service\">\r\n<h2>Водорослевое обертывание</h2>\r\n\r\n<p>Водорослевое обертывание</p>\r\n</div>\r\n', 'areablocknotitle', 260),
				(47, 'effektivnoe-prodvizhenie-predlagaemyh-uslug', 'Эффективное продвижение предлагаемых услуг', 7, 1, '<p>\r\n	Эффективное продвижение предлагаемых услуг</p>\r\n', 'areablocknotitle', 290),
				(48, 'uvelichenie-rynka-sbyta', 'Увеличение рынка сбыта', 7, 1, '<p>\r\n	Увеличение рынка сбыта</p>\r\n', 'areablocknotitle', 300),
				(49, 'rasshirenie-geografii-kompanii', 'Расширение географии компании', 7, 1, '<p>\r\n	Расширение географии компании</p>\r\n', 'areablocknotitle', 310),
				(50, 'slogan', 'slogan', 11, 1, '<a href=\"/\">\r\n					<div class=\"slogan\">\r\n						<span>sharkcompany</span>\r\n						<p>Почувствуй себя акулой бизнеса</p>\r\n					</div>\r\n				</a>', 'areablocknotitle', 320),
				(51, 'usluga-1', 'Услуга 1', 9, 1, '<div class = \"service\" >Услуга 1</span></div>\r\n', 'areablock', 330),
				(52, 'testovyj', 'Тестовый', 13, 0, 'фыфвы', 'areablock', 340);";

		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
				CREATE TABLE IF NOT EXISTS `banner_area` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) DEFAULT NULL,
				  `title` varchar(255) DEFAULT NULL,
				  `mode` int(11) DEFAULT NULL,
				  `queue` int(11) DEFAULT NULL,
				  `widget` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9;

				INSERT INTO `banner_area` (`id`, `name`, `title`, `mode`, `queue`, `widget`) VALUES
				(7, 'header', 'header', 1, NULL, '');";

		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
				CREATE TABLE IF NOT EXISTS `menu` (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `title` varchar(128) NOT NULL,
				  `name` varchar(128) NOT NULL,
				  `items_template` varchar(255) DEFAULT NULL,
				  `activeitem_class` varchar(255) DEFAULT NULL,
				  `firstitem_class` varchar(255) DEFAULT NULL,
				  `lastitem_class` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `NAME` (`name`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


				INSERT INTO `menu` (`id`, `title`, `name`, `items_template`, `activeitem_class`, `firstitem_class`, `lastitem_class`) VALUES
				(1, 'Главное меню', 'main', '{menu}', '', 'home', '');";

		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
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
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;


			INSERT INTO `menu_item` (`id`, `title`, `link`, `parent_id`, `menu_id`, `sort_order`) VALUES
			(1, 'О компании', '/about', 0, 1, 10),
			(2, 'Услуги', '/services', 0, 1, 20),
			(3, 'Фотогалерея', '/gallery', 0, 1, 30),
			(4, 'Новости', '/news', 0, 1, 40),
			(5, 'Отзывы', '/reviews', 0, 1, 50),
			(6, 'Контакты', '/callback', 0, 1, 60);";

		$this->dbConnection->createCommand($sql)->execute();

		$sql = "
			CREATE TABLE IF NOT EXISTS `page` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `parent_id` int(11) unsigned NOT NULL,
			  `link` varchar(128) NOT NULL DEFAULT '',
			  `title` varchar(512) NOT NULL DEFAULT '',
			  `content` longtext,
			  `keywords` varchar(1000) DEFAULT NULL,
			  `description` varchar(1000) DEFAULT NULL,
			  `layout` varchar(255) DEFAULT NULL,
			  `view` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `LINK` (`link`),
			  KEY `PARENT` (`parent_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

			INSERT INTO `page` (`id`, `parent_id`, `link`, `title`, `content`, `keywords`, `description`, `layout`, `view`) VALUES
				(16, 0, 'main', 'Главная', '', 'Главная', 'Главная', 'first_page', 'notitle');";

		$this->dbConnection->createCommand($sql)->execute();
	}

	public function down()
	{

		$sql = "
			DROP TABLE IF EXISTS area,
						 area_block,
						 banner_area,
						 menu,
						 menu_item,
						 page;";
		$this->dbConnection->createCommand($sql)->execute();


		$sql = "
			RENAME TABLE area_old TO area,
						 area_block_old TO area_block,
						 banner_area_old TO banner_area,
						 menu_old TO menu,
						 menu_item_old TO menu_item,
						 page_old TO page;
		";
		$this->dbConnection->createCommand($sql)->execute();

	}
}