<?php

define('SSORDER_OPENAPI_HOST_PROD', 'https://order.snlb.pl/v1/');
define('SSORDER_OPENAPI_HOST_DEVELOPER', 'https://develop.order.snlb.pl/v1/');

require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@common', __DIR__ . '/../../common');
Yii::setAlias('@frontend', __DIR__ . '/../../frontend');
Yii::setAlias('@console', __DIR__ . '/../../console');
