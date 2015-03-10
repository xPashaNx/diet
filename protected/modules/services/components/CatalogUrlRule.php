<?php

class CatalogUrlRule extends CBaseUrlRule
{
    /**
     * @var string
     */
    public $connectionID = 'db';

    /**
     * @param $manager
     * @param $route
     * @param $params
     * @param $ampersand
     *
     * @return bool
     */
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return false;
    }

    /**
     * Parse url
     *
     * @param $manager
     * @param $request
     * @param $pathInfo
     * @param $rawPathInfo
     *
     * @return bool|string
     */
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('%^(/?([\w\-.]+))+$%', $pathInfo, $matches))
        {
			$pages = preg_split("/\//",$pathInfo);
            $element_arr = explode ('.', end($pages));
            $element = $element_arr[0];
			if ($page = CatalogCategory::model()->find(array('condition'=>'link=:link', 'params'=>array(':link'=>$element),)))
				return '/services/default/category/link/'.$element;
            else
                if ($service = CatalogService::model()->find(array('condition'=>'link=:link', 'params'=>array(':link'=>$element),)))
                    return '/services/default/service/id/'.$service->id;
                else
                    return false;
        }

        return false;
    }
}