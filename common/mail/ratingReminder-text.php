<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $order common\models\Order */

$ratingUrl = \mmo\yii2\helpers\UrlHelper::toRouteSigned(['/rating/token', 'order' => $order->id], getenv('YII_COOKIE_VALIDATION_KEY'), true);
?>
Siemka <?= $user->username ?>,

Możesz ocenić swoje zamówienie:

<?= $ratingUrl ?>
