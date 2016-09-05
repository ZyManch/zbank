<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'zTrack',
    'preload'=>array('loader'),
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'localeClass' => 'YiiLocale',
    'import'=>array(
        'application.models.original.*',
        'application.models.search.*',
        'application.models.*',
        'application.forms.*',
        'application.components.*',
        'application.components.branchDetector.*',
        'application.components.currencyDetector.*',
        'application.controllers.*',
        'application.behaviors.*',
        'application.banks.*',
    ),

    // application components
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host='.$secure['db']['hostname'].';dbname='.$secure['db']['database'],
            'emulatePrepare' => true,
            'username' => $secure['db']['username'],
            'password' => $secure['db']['password'],
            'charset' => 'utf8',
            'nullConversion' => PDO::NULL_EMPTY_STRING,
            'schemaCachingDuration' => 3600 * 24,
            'enableParamLogging'    => true
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
            'directoryLevel' =>1,
            'cachePath' => dirname(__FILE__).'/../../cache/'
        ),
        'loader' => array(
            'class'=>'Loader',
        ),
        'authManager'=>array(
            'class' => 'AuthManager',
        ),
        'user'=>array(
            'class'=>'WebUser',
            'loginUrl'=>array('user/login'),
            'allowAutoLogin'=>true,
        ),
        'geocoder' => array(
            'class' => 'Geocoder',
            'developer_key' => ''
        )
    ),
    'params'=>array(
        'salt' => 'salt',
        'error_queue' => $secure['queue']['error']
    ),
);