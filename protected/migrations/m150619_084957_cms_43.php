<?php

class m150619_084957_cms_43 extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("
			ALTER TABLE  `catalog_config` ADD  `widget_count` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `service_perpage`;
			UPDATE `catalog_config` SET `widget_count`=4;
		")->execute();

		$this->dbConnection->createCommand("
			DELETE FROM `area_block` WHERE `area_id`=13;
			DELETE FROM `area` WHERE `name`='vashi-uslugi-na-glavnoj';
			DELETE FROM `area_block_old` WHERE `area_id`=13;
			DELETE FROM `area_old` WHERE `name`='vashi-uslugi-na-glavnoj';
		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("
			ALTER TABLE  `catalog_config` DROP  `widget_count`;
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