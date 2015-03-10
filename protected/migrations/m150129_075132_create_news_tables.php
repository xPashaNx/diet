<?php

class m150129_075132_create_news_tables extends CDbMigration
{
    public function up()
    {
        $this->dbConnection->createCommand("
            CREATE TABLE IF NOT EXISTS `news` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `link` varchar(255) NOT NULL,
          `date` datetime NOT NULL,
          `annotation` varchar(255) NOT NULL,
          `description` text NOT NULL,
          `meta_keywords` text NOT NULL,
          `meta_description` text NOT NULL,
          `public` tinyint(1) NOT NULL,
          `cover_id` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `link` (`link`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

        INSERT INTO `news` (`id`, `title`, `link`, `date`, `annotation`, `description`, `meta_keywords`, `meta_description`, `public`, `cover_id`) VALUES
        (1, 'Первая новость', 'pervaja-novost', '2015-01-28 21:36:18', 'Первая новость! Первая новость!', '<div>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit veritatis reprehenderit perspiciatis, corporis recusandae velit nisi natus maxime reiciendis, obcaecati, quis dignissimos. Magnam, accusantium, quaerat! Voluptatibus dolores cupiditate nihil doloribus amet, minima necessitatibus a quasi recusandae. Est quibusdam ducimus minus ex delectus eius consequuntur laborum doloremque a? Aliquam illo modi quasi laborum ea numquam totam facere voluptatibus at quas? Facilis at labore voluptatum aperiam magnam nostrum, eos culpa cupiditate odio distinctio unde, porro ullam quas enim, accusamus suscipit velit. Quis corporis nostrum debitis, incidunt mollitia alias, non adipisci quas eum. Praesentium blanditiis nam qui minus ratione dolorum ab aut architecto maxime aperiam culpa a dolores sint maiores fugit officia, mollitia sed dolore necessitatibus quas excepturi ut optio facilis? Delectus, illo, enim. Non possimus quaerat eum reiciendis inventore perspiciatis nemo ad maxime nulla quae. In placeat pariatur fugit. Soluta labore hic adipisci eius repellat fugit natus, ex quod dolorum expedita, facere non veritatis accusamus animi minima exercitationem omnis voluptatibus illum suscipit impedit. Earum quod, nihil sint quam voluptatem a in provident. Expedita ab recusandae culpa velit deserunt cum maiores quod, soluta dolorem assumenda commodi beatae. Deleniti neque necessitatibus dolores non omnis excepturi magnam, beatae, aut mollitia esse voluptatibus maxime! Harum numquam doloremque assumenda officiis optio. Ratione illum ut harum excepturi mollitia iure vero esse modi, laudantium, praesentium eligendi neque possimus animi, sint non reprehenderit fuga vel dolores nemo. Repellat rem esse maiores veniam pariatur deleniti vero distinctio sequi non tempora ab quis repudiandae quaerat recusandae minima quibusdam totam suscipit molestias nulla, modi porro nisi reprehenderit cum quisquam. Facilis, ullam. Incidunt voluptate molestias quisquam, consectetur laboriosam excepturi quis numquam aliquam exercitationem similique inventore voluptates quibusdam accusantium voluptatibus esse nulla sapiente itaque doloribus, obcaecati tempore animi, praesentium asperiores. Deserunt tempora, ratione laboriosam fugit ex cum fugiat sed culpa temporibus totam dicta eius, alias!</div>\r\n<div>\r\n	&nbsp;</div>\r\n', 'one news', 'one news', 1, 4),
        (2, 'Вторая новость', 'vtoraja-novost', '2015-01-28 21:39:17', 'Вторая новость! Вторая новость', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, a facilis tenetur. Hic quam placeat optio dolores esse facilis quis eius aspernatur iusto dolor, aut quos est. Enim inventore officia alias incidunt quis magni molestiae, consectetur vel, dolore, cum quibusdam, itaque ipsam architecto illo qui reprehenderit officiis numquam quisquam natus. Quia culpa eaque esse! Expedita officia cum incidunt doloremque, explicabo, harum delectus a nostrum. Ipsam reprehenderit adipisci, provident ipsum voluptate optio quibusdam vel necessitatibus dignissimos repudiandae officiis cupiditate velit quo consequuntur eos mollitia deserunt nesciunt asperiores cum quisquam? Repellat vel officiis architecto eius voluptatum perspiciatis sit. Quasi consequuntur vitae vel officiis quam voluptatem suscipit sunt, animi asperiores quidem, placeat ipsa odio consequatur minima voluptatum nulla amet ad libero. Quod praesentium incidunt, odio inventore. Reiciendis illum repudiandae eligendi fugiat explicabo dolor rerum adipisci natus vero eius obcaecati quam, distinctio, neque dolore dicta eaque suscipit numquam hic! Consectetur aspernatur vel reiciendis quisquam hic odit saepe nemo, voluptatem totam tenetur, sunt harum ratione neque eius vero dolorum, exercitationem nesciunt accusamus veritatis quod laborum ab error debitis quibusdam repudiandae. Eius perspiciatis fuga quis, autem, excepturi aliquam dolore rerum ullam. Recusandae quaerat odio atque sed, ipsam est assumenda, tenetur. Illum nisi ullam iusto dignissimos saepe.</p>\r\n', 'second news', 'second news', 1, 7),
        (3, 'Третья новость', 'tretja-novost', '2015-01-28 21:41:40', 'Третья новость! Третья новость!', '<div>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum corporis sit odit hic consequuntur eaque pariatur tenetur possimus sunt quaerat, accusantium unde sapiente aut! Natus id explicabo, perspiciatis sapiente ad, ratione, fuga fugiat velit illo numquam quos. Magni error nisi eveniet fugiat magnam dicta accusamus nulla repellendus cum possimus quam ex sint repudiandae unde labore cumque blanditiis, soluta, porro culpa amet quod! Earum aspernatur alias quas vero adipisci temporibus sint maiores, pariatur placeat debitis dolorem atque soluta doloribus est, sequi quae facere minus cum laudantium. Vero, ipsam cumque nihil, ut sequi, pariatur repellendus tempora, eaque laborum libero voluptas ex! Vero tempore quod quos, qui pariatur beatae dolorem. Laudantium impedit sed assumenda, accusamus recusandae tenetur possimus pariatur nisi quia iure vero, voluptatum ipsum eius, maiores blanditiis eaque. Unde velit quis quas nulla totam possimus itaque dolore! Neque exercitationem, fugiat sapiente facilis repellat natus! Aspernatur sequi labore velit asperiores ipsa aliquam, veritatis.</div>\r\n<div>\r\n	&nbsp;</div>\r\n', 'third news', 'third news', 1, 10),
        (4, 'Четвертая новость', 'chetvertaja-novost', '2015-01-28 21:43:58', 'Четвертая новость! Четвертая новость!', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto ratione molestiae eos minus veniam excepturi! Veniam perferendis itaque atque blanditiis. Ipsa, sed autem veniam pariatur, quibusdam voluptatem totam dolor nesciunt corporis aut nemo laboriosam odio a perspiciatis unde iusto laudantium asperiores consequatur! Esse neque sunt facilis aliquam saepe voluptatum, adipisci magnam earum quos eos dolor, quo itaque quaerat, quasi vitae voluptates. Ipsum rerum hic distinctio doloribus quibusdam officiis dolores laborum magni iure sapiente repellendus eius praesentium consectetur minus nihil atque, ut repudiandae, debitis eveniet commodi. Dignissimos suscipit minus voluptatibus. Dolor, pariatur ab, debitis dicta, similique beatae alias quibusdam, necessitatibus magnam nam officia. Quia, sapiente, necessitatibus. Facere sit pariatur aspernatur quas corporis ratione quam libero, nam, reiciendis a, ad rem illum modi. Dolorem totam sapiente odio non perspiciatis eaque, assumenda temporibus minus, placeat autem quod recusandae illo molestiae alias, possimus voluptatum nobis, mollitia dolor iste sequi cumque. Ratione veniam fuga id corporis voluptatibus illo, laboriosam dolor est, laudantium voluptatem, distinctio modi dolores, dicta mollitia itaque fugit ipsam quae eos. Earum, molestiae, qui? Temporibus dolor laboriosam illum unde dicta eligendi debitis nulla dignissimos veniam libero, ratione eveniet pariatur quod sint doloribus? Maiores aspernatur molestias error tempora fugit libero tenetur nam atque in!</p>\r\n', 'fourth news', 'fourth news', 1, 13),
        (5, 'Пятая новость', 'pjataja-novost', '2015-01-28 21:45:40', 'Пятая новость! Пятая новость!', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita nostrum odit voluptates, iste reiciendis fugiat cupiditate perspiciatis eos, possimus officiis sint sapiente rem. Neque labore cupiditate aut harum voluptates asperiores? Fuga laboriosam nostrum, necessitatibus tempora, in omnis tenetur adipisci nemo. Numquam amet qui, ipsum, aut quidem nihil accusantium laudantium cum tempore soluta ab at? Distinctio similique vel iste, officiis velit accusamus dolorem neque ea esse necessitatibus sunt consequuntur nulla ab deleniti fuga! Quae cumque repudiandae id a suscipit incidunt consectetur deserunt quas molestiae, accusantium ea itaque perferendis libero neque quia maiores debitis explicabo placeat, laudantium similique! Eum placeat reiciendis quisquam, sapiente. Voluptatem rerum eligendi quos velit, laboriosam deserunt maxime architecto placeat consequuntur sint enim, inventore omnis iste numquam assumenda odio a temporibus voluptatum animi, ducimus eveniet nam doloremque repudiandae! Asperiores ratione suscipit libero nemo vel, neque porro incidunt eum recusandae a. Est suscipit a quam vel. Maxime animi sunt officia!</p>\r\n', 'fifth news', 'fifth news', 1, 19);

        CREATE TABLE IF NOT EXISTS `news_config` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `view_count` int(11) NOT NULL,
          `widget_count` int(11) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

        INSERT INTO `news_config` (`id`, `title`, `view_count`, `widget_count`) VALUES
        (1, 'Новости', 4, 4);

        CREATE TABLE IF NOT EXISTS `news_images` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `news_id` int(11) NOT NULL,
          `filename` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

        INSERT INTO `news_images` (`id`, `news_id`, `filename`) VALUES
        (1, 1, '08aa843bb2a6ec8b31cda93500eef93e.jpg'),
        (2, 1, '53b6cd0934c2747a54a774b20b36cb68.jpg'),
        (3, 1, '1369201584fb888d2f58048788f6ff56.jpg'),
        (4, 1, 'fe04fe509b043636ba496efdf46ea9c8.jpg'),
        (5, 1, '47de74c3ff9782f885f05ac5b4bb0e75.jpg'),
        (6, 1, '8cc296ad24afdedb079f263c8c112b3c.jpg'),
        (7, 2, '0178125257b6cfd5f263cdefe958d0ed.jpg'),
        (8, 2, 'b8838269e2c778a3a2468b829de55149.jpg'),
        (9, 2, '0e2f6cc285afae0a145548d4b3375c3d.jpg'),
        (10, 3, '0eddc119608bd2cd09be6167687c2c18.jpg'),
        (11, 3, 'be478c9793fc8b963c0a3497a198d665.jpg'),
        (12, 3, '57c7c56d01739b59bc0d432512be3376.jpg'),
        (13, 4, '6e55a5e707ffb377f1ae743f4778ebe3.jpg'),
        (14, 4, '55854c893b5e56239a17b059ccd4fd49.jpg'),
        (15, 4, 'dfa677166f66975aef25e733cc4dc5c7.jpg'),
        (16, 4, 'f08d3674b8b0d0fd2dbdd5d90c7217fd.jpg'),
        (17, 4, 'e8904df57c6fe11ea1b3926265e3f468.jpg'),
        (18, 4, '14e212c35a15d72c3f47d4aaac2255dc.jpg'),
        (19, 5, '0b77edb288605d9be794eee960f2c44f.jpg'),
        (20, 5, '1100677950a0f8bf7451960defbc6ca1.jpg'),
        (21, 5, 'c724cd0717e0ebe4e7da6cb225c7b032.jpg'),
        (22, 5, '65ca6e578db6aecde58c2ff7f2852fe2.jpg');
		")->execute();
    }

    public function down()
    {
        $this->dbConnection->createCommand("
			DROP TABLE `news`;
			DROP TABLE `news_config`;
			DROP TABLE `news_images`;
		")->execute();
    }
}