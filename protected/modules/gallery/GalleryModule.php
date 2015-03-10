<?php

/**
 * Class GalleryModule
 */
class GalleryModule extends CWebModule
{
	/**
	 * Module init
	 */
	public function init()
	{
		$this->setImport(array(
			'gallery.models.*',
			'gallery.components.*',
		));
		$this->controllerPath = $this->getControllerPath() . DIRECTORY_SEPARATOR . Yii::app()->branch;
		$this->viewPath = $this->getViewPath() . DIRECTORY_SEPARATOR . Yii::app()->branch;
	}
	
	/**
	 * @param CController $controller
	 * @param CAction $action
	 * @return bool
	 */
	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
