<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.banners.models.*');
/*
Класс виджета для вывода баннеров

*/
class ViewWidget extends CWidget {

    // имя рекламного места
    public $areaname = '';
    public $viewName = 'view';
    public $itemViewName = '_view';

	public function	run() 
	{
        if ($bannerarea = Bannerarea::model()->find('name=:name', array('name' => $this->areaname)))
		{
            /*$criteria = new CDbCriteria;
            $criteria->condition = 'bannerarea=:bannerarea AND notactive<>1';
            $criteria->params = array('bannerarea' => $bannerarea->id);

            $dataProvider = new CActiveDataProvider('Banners', array(
                'criteria' => $criteria,
                'sort' => array(
                    'defaultOrder' => 'sort_order ASC',
                ),
            ));

            switch ($bannerarea->mode)
			{
                case 2: // Поочередная ротация
                    $dataProvider->pagination->pageSize = 1;

                    // Увеличиваем номер очередного баннера на 1
                    if (isset($bannerarea->queue))
					{
                        $bannerarea->queue = $bannerarea->queue+1;
                    }
					else
					{
						$bannerarea->queue = 0;
					}

                    // Если номер больше, чем общее количество - обнуляем
                    if($bannerarea->queue > $dataProvider->totalItemCount-1)
					{
						$bannerarea->queue = 0;
					}

                    // Устанавливаем текущую страницу
                    $dataProvider->pagination->currentPage = $bannerarea->queue;

                    // Сохраняем номер очередной просмотренной страницы
                    $bannerarea->save();
                    break;
                
                case 3:
                    $dataProvider->pagination->pageSize = 1;
                        
                    // Генерируем случайным образом номер баннера для показа
                    $bannerarea->queue = mt_rand(0, $dataProvider->totalItemCount-1);

                    // Устанавливаем текущую страницу
                    $dataProvider->pagination->currentPage = $bannerarea->queue;

                    // Сохраняем номер очередной просмотренной страницы
                    $bannerarea->save();
                    break;
					
                default:
                    $dataProvider->pagination = false;
                    break;
            }

            $this->render($this->viewName,array(
			   'dataProvider' => $dataProvider,
			   'itemViewName' => $this->itemViewName,
            ));

            return parent::run();*/
			
			$criteria = new CDbCriteria;
            $criteria->order = 'sort_order';
            $criteria->condition = 'bannerarea=:bannerarea AND notactive<>1';
            $criteria->params = array('bannerarea' => $bannerarea->id);
			$banners = Banners::model()->findAll($criteria);

            $this->render($this->viewName,array(
			   'banners' => $banners,
            ));

            return parent::run();

        } else {

            echo 'Рекламное место '.$this->areaname.'не найдено!';
        }
	}
}
?>
