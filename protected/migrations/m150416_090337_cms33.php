<?php

class m150416_090337_cms33 extends CDbMigration
{
	public function up()
	{
        $this->dbConnection->createCommand("
            ALTER TABLE `area_block` DROP COLUMN `css_class`
        ;")->execute();
        $this->dbConnection->createCommand("
            ALTER TABLE `callback_config` ADD (
			  `verify_code` tinyint(1) DEFAULT 0,
			  `email` varchar(255) NOT NULL,
			  `timeout` varchar(255) DEFAULT NULL
			)
        ;")->execute();
	}

	public function down()
	{
       $this->dbConnection->createCommand("
            ALTER TABLE `area_block` ADD `css_class` varchar(255) NOT NULL;
        ;")->execute();

        $this->dbConnection->createCommand("
            ALTER TABLE `callback_config`
              DROP COLUMN `verify_code`,
              DROP COLUMN `timeout`,
              DROP COLUMN `email`
        ;")->execute();

	}
}