<?php

$securePath = dirname(__FILE__).'/../config.secure.json';
if (!file_exists($securePath)) {
    print 'Secure file is missed';
    return;
}
$secure = json_decode(file_get_contents($securePath),1);
$yii=dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/config/console.php';
$staticConfig=dirname(__FILE__).'/config/static_config.php';
$config = require_once $config;
$staticConfig = require_once $staticConfig;
require_once dirname(__FILE__).'/merge.php';
$config = array_merge_config($staticConfig, $config);
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
if(isset($config)) {
    $app=Yii::createApplication('CConsoleApplication',$config);
    $app->commandRunner->addCommands(YII_PATH.'/cli/commands');
} else {
    $app = Yii::createApplication(
        'CConsoleApplication',
        array('basePath' => dirname(__FILE__) . '/cli')
    );
}
/** @var $app CConsoleApplication */
Yii::setPathOfAlias('vendor', dirname(__FILE__).'/../vendor');
$app->run();
