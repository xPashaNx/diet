<?php

class m150311_113914_banners_add extends CDbMigration
{
	public function up()
	{

        $this->dbConnection->createCommand("

			ALTER TABLE `banner_area` ADD `widget` varchar(255) DEFAULT NULL;

		")->execute();
	}

	public function down()
	{
        $this->dbConnection->createCommand("

			ALTER TABLE `banner_area` DROP `widget`;

		")->execute();
	}
}