<?php

return array(
    'components' => array(
        'user' => array(
            'loginUrl' => array('site/login'),
        ),
        'urlManager' => array(
            'rules' => array(
                '' => 'site/index',
                'cap' => 'site/cap',
                'login' => 'site/login',
                array(
                    'class' => 'application.components.PageUrlRule',
                    'lastSlashEnabled' => false,
                    // STRIP_LAST_SLASH or ADD_LAST_SLASH
                    'lastSlashType' => STRIP_LAST_SLASH,
                ),
                array(
                    'class' => 'application.modules.news.components.NewsUrlRule'
                ),
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'onBeginRequest' => array('ModulesUrlRules', 'getModuleRules'),
);
?>