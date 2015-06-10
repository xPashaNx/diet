<?php

class m150608_134856_catalog_service_add extends CDbMigration
{
	public function up()
	{
		$this->dbConnection->createCommand("
		
			DELETE FROM `catalog_service`
			WHERE `link` 
				IN ('Recruiting', 'Screening','Executive_Search','Assessment_Center');
			
			INSERT INTO `catalog_service` (`id_category`, `short_title`, `long_title`, `link`, `keywords`, `description`, `photo`, `on_main`, `text`, `sort_order`) 
			VALUES
				(0, 'Recruiting', 'Правильный выбор в океане кандидатов', 'RECRUITING', 'Осуществление бизнес-процессов и задач, направленных на решение кадровых вопросов компаний.', 'Рекрутинг (англ. recruiting) — это бизнес-процесс, являющийся одной из основных обязанностей <br>\r\nHR-менеджеров или рекрутеров. Также подбор персонала — основная услуга, предлагаемая кадровыми агентствами и специализированными интернет-сайтами по поиску персонала.', '491b107e575b3b2775f70c3002b6f4a6.jpg', 0, '<p>Выбор кандидата может помочь в увеличении производительности, прибыли и повышении лояльности сотрудников. Неправильный выбор обычно сказывается на большой текучке персонала или недостаточной компетенции сотрудников.</p>\r\n\r\n<p>Подбор персонала начинается с описания вакансии и анализа её на адекватность сложившейся ситуации на кадровом рынке и в компании-работодателе. При необходимости описание вакансии корректируется. Далее начинается этап поиска кандидатов. Желательно иметь начальную базу кандидатов, а в процессе работы постоянно её пополнять.</p>\r\n', 1),
				(0, 'Executive Search', NULL, 'Executive_Search', 'Подбор топ-менеджеров и других редких специалистов из небольшого числа высокооплачиваемых кандидатов.', NULL, NULL, 0, NULL, 2),
				(0, 'Assessment Center', NULL, 'Assessment_Center', 'Предлагает стандартизированную многоаспектную оценку персонала, тестирование, презентации и игры.', '', NULL, 0, NULL, 3),
				(0, 'Screening', NULL, 'Screening', 'Подбор по формальным требованиям с сопоставлением требований клиента с данными резюме и анкет кандидатов.', '', NULL, 0, NULL, 4);
		
		")->execute();
	}

	public function down()
	{
		$this->dbConnection->createCommand("
			DELETE FROM `catalog_service`
			WHERE `link` 
				IN ('Recruiting', 'Screening','Executive_Search','Assessment_Center');		
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

