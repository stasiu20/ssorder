<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Siemka <?= $user->username ?>,

Przejdź do linku poniżej żeby zmienić twoje hasło:

<?= $resetLink ?>
