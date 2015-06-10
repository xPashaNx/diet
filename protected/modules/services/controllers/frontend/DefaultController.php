<?php

/**
 * Class DefaultController
 */
class DefaultController extends BaseCatalogController
{
    /**
     * @var int
     */
    public $category = 0;
    public $long_title = 'Полное название';
    public $short_title = 'Короткое название';
    public $text = 'Текст';
    public $photo = 'Имя фото';
    public $keywords = 'Ключевые слова';

    /**
     * Lists all models
     */
	public function actionIndex()
	{
		$this->breadcrumbs[] = $this->catalog_config->title;
		$services_criteria = new CDbCriteria;
		$services_criteria->compare('id_category', 0);
		$this->metaInfoGenerate($this->catalog_config->title, $this->catalog_config->keywords, $this->catalog_config->description);

		if ($this->catalog_config->layout)
			$this->layout = $this->catalog_config->layout;

		$sql = "
				SELECT
					id,
					short_title,
					description,
					keywords,
					link,
					sort_order
				FROM
					`catalog_service`
				ORDER BY `sort_order`";

		$rawData=Yii::app()->db->createCommand($sql)->queryAll();

		$dataProvider = new CArrayDataProvider($rawData, array(
			'id'=>'user',
			'sort'=>array(
				'attributes'=>array(
					'id', 'short_title', 'link',
				),
			),
			'pagination'=>array(
				'pageSize' => CatalogConfig::model()->findByPk(1)->category_perpage,
			),
		));
	
		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

    /**
     * List categories
     *
     * @param string $link
     *
     * @throws CHttpException
     */
	public function actionCategory($link)
	{
		$category = $this->loadCategoryModel($link);
		$this->breadcrumbs = CatalogCategory::getBreadcrumbs($category->id, false);
		$this->breadcrumbs[] = $category->short_title;

        $this->metaInfoGenerate($category->short_title, $category->keywords, $this->catalog_config->description);

	    if($this->catalog_config->layout)
            $this->layout = $this->catalog_config->layout;

		$dataProvider = new CActiveDataProvider('CatalogService',
			array(
				'criteria' => array(
					'order' => 'sort_order ASC',
					'condition'=>'id_category =' .  $category->id,
				),
				'pagination' => array(
					'pageSize' => CatalogConfig::model()->findByPk(1)->service_perpage,
				),
			));


		$this->render('view',array(
			'category' => $category,
			'dataProvider' => $dataProvider,
		));
	}
	public function actionView($id)
    {
	
        $model = $this->loadModel($id);

        //Фотогалерея
        $criteria = new CDbCriteria();
        $criteria->compare('id_service', $id);

        $imagesDataProvider = new CActiveDataProvider('CatalogImage', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        //формируем short_title страницы, description, keywords
        //$this->title = "УСЛУГА" . " - " . $model->short_title;
		$this->long_title = $model->long_title;
		$this->short_title = $model->short_title;
        $this->description = $model->description;
        $this->keywords = $model->keywords;	
        $this->text = $model->text;	
        $this->photo = $model->photo;	

        $this->render('view', array(
            'model' => $model,
            //'titleListNews' => $this->config->title,
            'titleBreadcrumbs' => $model->link,
            'imagesDataProvider' => $imagesDataProvider,
            //'folder_upload' => CatalogService::FOLDER_UPLOAD,

        ));
		/*
		*/
    }
    /**
     * List service
     *
     * @param integer $id
     *
     * @throws CHttpException
     */
	public function actionService($id)
	{
		$model = $this->loadServiceModel($id);

		$this->breadcrumbs = CatalogCategory::getBreadcrumbs($model->id_category, true);
		$this->breadcrumbs[] = $model->short_title;
        $this->metaInfoGenerate($model->short_title, $model->keywords, $this->catalog_config->description);

		$this->render('service',array(
			'category' => $model,
		));
	}

    /**
     * Load category model
     *
     * @param string $link
     *
     * @return mixed
     * @throws CHttpException
     */
	public function loadCategoryModel($link)
	{
		$model = CatalogCategory::model()->findByAttributes(array('link' => $link));
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

		return $model;
	}

    /**
     * Load product model
     *
     * @param integer $id
     *
     * @return mixed
     * @throws CHttpException
     */
	public function loadServiceModel($id)
	{
		$model = CatalogService::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');

		return $model;
	}

    /**
     * Create url
     *
     * @param string $route
     * @param array  $params
     * @param string $ampersand
     *
     * @return string
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if ($route == 'category')
            if (isset($params['link']))
                return '/services'.CatalogCategory::getCategoryRoute($params['link']);

        if ($route == 'service')
        {
            if (isset($params['id']))
            {
                if ($service = CatalogService::model()->find(array('condition' => 'id=:id', 'params' => array(':id' => $params['id']),)))
                {
                    $category = CatalogCategory::model()->findByPk($service->id_category);
                    return '/services'.CatalogCategory::getCategoryRoute($category->link).'/'.$service->id;
                }
            }
        }

        return parent::createUrl($route, $params, $ampersand);
    }
	public function loadModel($id)
    {
        $model = CatalogService::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}