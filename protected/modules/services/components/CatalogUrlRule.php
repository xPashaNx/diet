<?php

class CatalogUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        return false;
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^(/?([\w\-.]+))+$%', $pathInfo, $matches))
        {
			$pages = preg_split("/\//",$pathInfo);
            $element_arr = explode ('.', end($pages));
            //var_dump($pages); die;
            $element = $element_arr[0];
			if ($page = CatalogCategory::model()->find(array('condition'=>'link=:link', 'params'=>array(':link'=>$element),)))
				return '/catalog/default/category/link/'.$element;
            else
                if ($service = CatalogService::model()->find(array('condition'=>'link=:link', 'params'=>array(':link'=>$element),)))
                    return '/catalog/default/service/id/'.$service->id;
                else
                    return false;
        }

        return false;
    }
}