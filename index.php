<?php


if(!file_exists(__DIR__.'/config/db.php')) {
    header('Location: edusec-requirements.php');
    die;
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');
$app = new yii\web\Application($config);
$app->run();