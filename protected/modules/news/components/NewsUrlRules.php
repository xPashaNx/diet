<?php

class NewsUrlRules extends CBaseUrlRule
{

    public function createUrl($manager, $route, $params, $ampersand)
    {
        if ($route == 'news/default/view') {
            if (!empty($params['id'])) {
                if ($page = News::model()->findByPk($params['id'])) {
                    return 'news/' . $page->link . '.html';
                }
            }
        }
        if ($route == 'news/default/') {
            if (empty($params['id'])) {
                return 'news';
            }
        }
        return FALSE;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if ($link = preg_split("/\//", $pathInfo)) {

            if (count($link) == 1 && end($link) == 'news') return 'news/default';

            if (count($link) > 1 && $news = News::model()->findByAttributes(array('link' => substr($link[1], 0, -5)))) {
                if ($news !== null) return 'news/default/view/id/' . $news->id;
            }
        }
        return false;
    }

}
