<?php

$yii=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/main.php';
$staticConfig=dirname(__FILE__).'/../protected/config/static_config.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
if (!file_exists($yii)) {
    print 'Install composer and try again';
    return;
}
$securePath = dirname(__FILE__).'/../config.secure.json';
if (!file_exists($securePath)) {
    print 'Secure file is missed';
    return;
}
require_once($yii);
$secure = json_decode(file_get_contents($securePath),1);
$config = require_once $config;
$staticConfig = require_once $staticConfig;
require_once dirname(__FILE__).'/../protected/merge.php';
$mergedConfig = array_merge_config($staticConfig, $config);
$app = Yii::createWebApplication($mergedConfig);
Yii::setPathOfAlias('vendor', dirname(__FILE__).'/../vendor');
$app->run();
