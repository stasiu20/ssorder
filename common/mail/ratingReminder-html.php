<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $order common\models\Order */

$ratingUrl = \mmo\yii2\helpers\UrlHelper::toRouteSigned(['/rating/token', 'order' => $order->id], getenv('YII_COOKIE_VALIDATION_KEY'), true);
?>

<div class="password-reset">
    <p>Siemka <?= Html::encode($user->username) ?>,</p>

    <p>Możesz ocenić swoje zamówienie:</p>

    <p><?= Html::a(Html::encode($ratingUrl), $ratingUrl) ?></p>
</div>
