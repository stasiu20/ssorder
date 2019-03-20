<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
\frontend\assets\WebpackAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" href="/image/sensisoft.png" type="image/x-icon"/>
    <link href="/css/lightbox.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Google Analytics -->
    <script>
        window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
        ga('create', '<?= \frontend\helpers\GoogleAnalyticsHelper::getTrackingId() ?>', 'auto');
        <?php if (!\Yii::$app->user->isGuest): ?>
            ga('set', 'userId', <?= \frontend\helpers\GoogleAnalyticsHelper::getUserId() ?>);
        <?php endif; ?>
        ga('send', 'pageview');
    </script>
    <?php if (\frontend\helpers\GoogleAnalyticsHelper::isEnabledGA()): ?>
        <script async src='https://www.google-analytics.com/analytics.js'></script>
    <?php endif; ?>
    <!-- End Google Analytics -->
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/image/sensilabs-logo.png">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        //['label' => 'About', 'url' => ['/site/about']],
        //['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Dodaj Restaurację', 'url' => ['/restaurants/upload']];
        $menuItems[] = ['label' => 'Zamówienia', 'url' => ['/order/index']];
        $menuItems[] = ['label' => 'Rozliczenie', 'url' => ['/payment/manage']];
        $menuItems[] = ['label' => 'Historia', 'url' => ['/history/my']];
        $menuItems[] = [
            'label' => 'TY',
            'items' => [
                ['label' => 'Profil', 'url' => ['/profile']],
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                ]
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Stasiu <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>
<script src="/js/lightbox-plus-jquery.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
