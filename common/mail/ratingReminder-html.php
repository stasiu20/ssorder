<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$ratingUrl = Yii::$app->urlManager->createAbsoluteUrl(['/history/my']);
?>

<div class="password-reset">
    <p>Siemka <?= Html::encode($user->username) ?>,</p>

    <p>Możesz ocenić swoje zamówienia:</p>

    <p><?= Html::a(Html::encode($ratingUrl), $ratingUrl) ?></p>
</div>
