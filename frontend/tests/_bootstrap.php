<?php
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', __DIR__ . '/../../');
require_once(YII_APP_BASE_PATH . '/vendor/autoload.php');

$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->load(__DIR__ . '/../../.env');

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));

require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once(YII_APP_BASE_PATH . '/common/config/bootstrap.php');
require_once(__DIR__ . '/../config/bootstrap.php');
