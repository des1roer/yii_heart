<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'WebApp',
    'language' => 'ru',
    'sourceLanguage' => 'en_US',
    'theme' => 'heart',
    'charset' => 'utf-8',
    'timeZone' => 'Asia/Yekaterinburg',
    // preloading 'log' component
    'preload' => array('booster'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'root',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array('ext.heart.gii'),
        ),
    ),
    // application components
    'components' => array(
        'booster' => array(
            'class' => 'application.extensions.yiibooster.components.Bootstrap', 
            'fontAwesomeCss' => true,
            'minify' => true,
        ),
        'themeManager' => array(
            'basePath' => 'protected/extensions',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                // стандартное правило для обработки '/' как 'site/index'
                '' => 'site/index',
                // это пример добавления который заработал
                //'secondcontroller/<action:.*>'=>'secondcontroller/<action>',
                'user/<action:.*>' => 'user/<action>',
                //'<action:.*>'=>'site/<action>', //закомментил а то глючило с ним
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
