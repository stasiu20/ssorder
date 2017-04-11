<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Siemka <?= Html::encode($user->username) ?>,</p>

    <p>Przejdź do linku poniżej żeby zmienić twoje hasło:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
