<!-- Google Analytics -->
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '<?= \frontend\helpers\GoogleAnalyticsHelper::getTrackingId() ?>', 'auto');
<?php if (!\Yii::$app->user->isGuest): ?>
ga('set', 'userId', <?= \frontend\helpers\GoogleAnalyticsHelper::getUserId() ?>);
<?php endif; ?>
ga('send', 'pageview');
<!-- End Google Analytics -->
