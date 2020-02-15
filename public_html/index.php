<?php
define('RP_HTTP_ROOT',__DIR__);
define('RP_APP_ROOT',dirname(__DIR__).'/radiantApp');
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');


require RP_APP_ROOT . '/vendor/autoload.php';
require RP_APP_ROOT . '/vendor/yiisoft/yii2/Yii.php';
require RP_APP_ROOT . '/common/config/bootstrap.php';
require RP_APP_ROOT . '/frontend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require RP_APP_ROOT . '/common/config/main.php',
    require RP_APP_ROOT . '/frontend/config/main.php'
);
(new yii\web\Application($config))->run();
