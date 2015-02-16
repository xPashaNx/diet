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

    /**
     * Lists all models
     */
	public function actionIndex()
	{
		$this->breadcrumbs[] = $this->catalog_config->title;
		$services_criteria = new CDbCriteria;
        $services_criteria->compare('id_category', 0);

        $categories = CatalogCategory::model()->findAll();

        $this->metaInfoGenerate($this->catalog_config->title, $this->catalog_config->keywords, $this->catalog_config->description);

	    if ($this->catalog_config->layout)
            $this->layout = $this->catalog_config->layout;

		$this->render('index',array(
            'categories' => $categories,
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
  
		$this->render('view',array(
			'category' => $category,
		));
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
			'model' => $model,
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
}