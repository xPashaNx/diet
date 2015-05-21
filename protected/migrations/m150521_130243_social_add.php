<?php

class m150521_130243_social_add extends CDbMigration
{
	public function up()
	{

		$this->dbConnection->createCommand("
			DELETE FROM `area_block`
			WHERE `area_id` = 10;

			INSERT INTO `area_block`
				(`name`, `title`, `area_id`, `visible`, `content`, `view`, `sort_order`)
			VALUES
				('vk', 'vk', 10, 1, '<p><img alt=\"\" src=\"/images/social-vk.png\" style=\"height:42px; width:42px\" /></p>\r\n', 'areablocknotitle', 350),
				('fb', 'fb', 10, 1, '<p><img alt=\"\" src=\"/images/social-fb.png\" style=\"height:42px; width:42px\" /></p>\r\n', 'areablocknotitle', 360),
				('in', 'in', 10, 1, '<p><img alt=\"\" src=\"/images/social-in.png\" style=\"height:42px; width:42px\" /></p>\r\n', 'areablocknotitle', 370),
				('tw', 'tw', 10, 1, '<p><img alt=\"\" src=\"/images/social-tw.png\" style=\"height:42px; width:42px\" /></p>\r\n', 'areablocknotitle', 380);
		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("
			DELETE FROM `area_block`
			WHERE `area_id` = 10;
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