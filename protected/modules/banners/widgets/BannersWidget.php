<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.banners.models.*');

/**
 * Class BannersWidget to display banners
 */
class BannersWidget extends CWidget 
{
    /**
     * @var string banner area name
     */
    public $areaname = '';

    /**
     * @var string view name
     */
    public $viewName = 'banners';

    /**
     * @var string item view name
     */
    public $itemViewName = '_banner';

    /**
     * @method run
     */
	public function	run() 
	{
        if ($bannerarea = Bannerarea::model()->find('name=:name', array('name' => $this->areaname)))
		{
			$banners = array();
			$typeRotation = false;
            $criteria = new CDbCriteria;
            $criteria->condition = 'bannerarea=:bannerarea AND notactive<>1';
            $criteria->params = array('bannerarea' => $bannerarea->id);
			
			switch ($bannerarea->mode)
			{
				case Bannerarea::SHOW_ALL:
					$criteria->order = 'sort_order';
					break;
				case Bannerarea::RANDOM_ALL:
					$criteria->order = new CDbExpression('RAND()');
					break;
			}

            $dataProvider = new CActiveDataProvider('Banners', array(
                'criteria' => $criteria,
            ));
          
            switch ($bannerarea->mode)
			{
                case Bannerarea::ONE_AT_ROTATION: // Поочередная ротация
					$typeRotation = true;
                    $dataProvider->pagination->pageSize = 1;

                    // Увеличиваем номер очередного баннера на 1
                    if (isset($bannerarea->queue))
                        $bannerarea->queue = $bannerarea->queue+1;
					else
						$bannerarea->queue = 0;

                    // Если номер больше, чем общее количество - обнуляем
                    if ($bannerarea->queue > $dataProvider->totalItemCount-1)
					{
						$bannerarea->queue = 0;
					}

                    // Устанавливаем текущую страницу
                    $dataProvider->pagination->currentPage = $bannerarea->queue;

                    // Сохраняем номер очередной просмотренной страницы
                    $bannerarea->save();
                    break;
                
                case Bannerarea::RANDOM_ROTATION:
					$typeRotation = true;
                    $dataProvider->pagination->pageSize = 1;
                        
                    // Генерируем случайным образом номер баннера для показа
                    $bannerarea->queue = mt_rand(0, $dataProvider->totalItemCount-1);

                    // Устанавливаем текущую страницу
                    $dataProvider->pagination->currentPage = $bannerarea->queue;

                    // Сохраняем номер очередной просмотренной страницы
                    $bannerarea->save();
                    break;
				
				case Bannerarea::SLIDER:
					$this->viewName = 'slider';
					$banners = Banners::model()->findAll($criteria);
					break;
					
                default:
                    $dataProvider->pagination = false;
                    break;
            }

            $this->render($this->viewName, array(
			   'dataProvider' => $dataProvider,
			   'itemViewName' => $this->itemViewName,
			   'banners' => $banners,
			   'typeRotation' => $typeRotation,
            ));

            return parent::run();
        } 
		else 
		{
            echo 'Рекламное место '.$this->areaname.'не найдено!';
        }
	}
}
?>
