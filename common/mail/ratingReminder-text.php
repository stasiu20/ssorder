<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$ratingUrl = Yii::$app->urlManager->createAbsoluteUrl(['/history/my']);
?>
Siemka <?= $user->username ?>,

Możesz ocenić swoje zamówienia:

<?= $ratingUrl ?>
