<?php

class NewsUrlRule extends CBaseUrlRule {

    public function createUrl($manager, $route, $params, $ampersand) {
        if ($route == 'news/default/view') {
            if (!empty($params['id'])) {
                if ($page = News::model()->findByPk($params['id'])) {
                    return 'news/' . $page->link . '.html';
                }
            }
        }
        if ($route == 'news/default/') {
            if (empty($params['id'])) {
                return 'news/';
            }
        }
        return FALSE;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $link = explode('/', $pathInfo);
        if (is_array($link) && count($link) > 1) {
            $news = News::model()->find(array(
                'condition' => 'link = :link',
                'params' => array(':link' => substr($link[1], 0, -5)),
            ));
            if ($news !== NULL) {
                return 'news/default/view/id/' . $news->id;
            }
        }
        if (is_array($link) && count($link) == 1) {
            return 'news/default';
        }
        return FALSE;
    }

}
