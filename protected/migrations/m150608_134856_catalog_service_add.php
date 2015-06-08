<?php

class m150608_134856_catalog_service_add extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("
		
			DELETE FROM `corp-plusonecms`.`catalog_service` 
			WHERE `link` 
				IN ('RECRUITING', 'SCREENING','EXECUTIVE_SEARCH','ASSESSMENT_CENTER');
			INSERT INTO `corp-plusonecms`.`catalog_service`(`short_title`, `description`, `link`)
			VALUES ('RECRUITING',
						   'Осуществление бизнес-процессов и задач, направленных на решение кадровых вопросов компаний.','RECRUITING');
			INSERT INTO `corp-plusonecms`.`catalog_service`(`short_title`, `description`,`link`)
			VALUES ('SCREENING',
						   'Подбор по формальным требованиям с сопоставлением требований клиента с данными резюме и анкет кандидатов.','SCREENING');
			INSERT INTO `corp-plusonecms`.`catalog_service`(`short_title`, `description`,`link`)
			VALUES ('EXECUTIVE SEARCH',
						   'Подбор топ-менеджеров и других редких специалистов из небольшого числа высокооплачиваемых кандидатов.','EXECUTIVE_SEARCH');
			INSERT INTO `corp-plusonecms`.`catalog_service`(`short_title`, `description`,`link`)
			VALUES ('ASSESSMENT CENTER',
						   'Предлагает стандартизированную многоаспектную оценку персонала, тестирование, презентации и игры.','ASSESSMENT_CENTER');
		
		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("
		
			DELETE FROM `corp-plusonecms`.`catalog_service` 
			WHERE `link` 
				IN ('RECRUITING', 'SCREENING','EXECUTIVE_SEARCH','ASSESSMENT_CENTER');
		
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

