<?php
/**
 * Controller is the customized backend controller class.
 * All backend controller classes for this application should extend from this base class.
 */
class BackEndController extends BaseController
{
	//public $layout = '//layouts/column2';

    public function filters()
    {
		return array(
			'accessControl',
		);
    }

    public function accessRules()
    {
        return array(
			array('allow',
				'roles' => array('admin'),
			),
            array('deny',
				'users' => array('*'),
            ),
        );
    }

    public function menuWidgets()
    {
		if (file_exists(YiiBase::getPathOfAlias("application.widgets.AdminmenuWidget") . '.php'))
			$this->widget("application.widgets.AdminmenuWidget");
			
		foreach(Yii::app()->modulesMenus as $path)
			$this->widget($path);
    }

    protected function beforeAction($action)
    {
        $route = $this->id . '/'. $action->id;
        if (!$this->allowIp(Yii::app()->request->userHostAddress) and $route !== 'main/error')
            throw new CHttpException(403, "У вас недостаточно прав для просмотра данной страницы. Ваш IP-адрес: " . Yii::app()->request->userHostAddress);

        return parent::beforeAction($action);
    }

    /**
     * Checks to see if the user IP is allowed by {@link ipFilters}.
     * @param string $ip the user IP
     * @return boolean whether the user IP is allowed by {@link ipFilters}.
     */
    protected function allowIp($ip)
    {
        if (empty(Yii::app()->params['ipFilters']))
            return true;

        foreach(Yii::app()->params['ipFilters'] as $filter)
        {
            if ($filter === '*' or $filter === $ip or (($pos = strpos($filter,'*')) !== false and !strncmp($ip, $filter, $pos)))
                return true;
        }

        return false;
    }
}
?>