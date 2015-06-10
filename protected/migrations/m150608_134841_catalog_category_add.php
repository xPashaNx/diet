<?php

class m150608_134841_catalog_category_add extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("
			
			DELETE FROM `corp-plusonecms`.`catalog_category` 
			WHERE 
				`link` = 'head-category';
			
			INSERT INTO `corp-plusonecms`.`catalog_category`( `short_title`, 
											`long_title`, 
											`link`) 
			VALUES ('Главная категория',
					'Общая категория для всех услуг',
					'head-category')

		")->execute();
	}

	public function down()
	{
		$this->dbconnection->createCommand("
			DELETE FROM `corp-plusonecms`.`catalog_category` 
			WHERE 
				`link` = 'head-category';
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

