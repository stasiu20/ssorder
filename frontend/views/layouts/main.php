<?php

/* @var $this \yii\web\View */
/* @var $content string */

/** @var AppVersion $appVersion */
$appVersion = $this->params['appVersion'];

use common\component\UserRestApiMediator;
use mmo\yii2\helpers\AppVersionHelper;
use mmo\yii2\models\AppVersion;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use \yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
\frontend\assets\WebpackAsset::register($this);
\frontend\helpers\GoogleAnalyticsHelper::registerJs();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="manifest" href="/manifest.json" />
    <link rel="icon" href="/image/sensisoft.png" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript">
        function getJWTToken() {
            return '<?= Yii::$app->session->get(UserRestApiMediator::JWT_SESSION_KEY) ?>';
        }
    </script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'id' => 'navbar',
        'brandLabel' => '<img src="/image/sensilabs-logo.png">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark sticky-top navbar--visible',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Dodaj Restaurację', 'url' => ['/restaurants/add']];
        $menuItems[] = ['label' => 'Zamówienia', 'url' => ['/order/index']];
        $menuItems[] = ['label' => 'Rozliczenie', 'url' => ['/payment/manage']];
        $menuItems[] = ['label' => 'Historia', 'url' => ['/history/my']];
        $menuItems[] = [
            'label' => 'TY',
            'dropdownOptions' => ['class' => 'dropdown-menu dropdown-menu-right'],
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
        'options' => ['class' => 'nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container my-4">
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <div id="react-toastify"></div>
</div>

<footer class="footer clearfix p-4">
    <p class="float-left">
        &copy; Stasiu 2017 - <?= date('Y') ?>
    </p>
    <p class="float-right">
        <?= Yii::t('app', 'Wersja') ?> <?= $appVersion->getVersion(); ?>
    </p>
</footer>
<script type="application/javascript">
    function getVAPIDPubKey() {
        return '<?= getenv('WEBPUSH_PUB_KEY') ?>';
    }

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js').catch(registrationError => {
                console.error(registrationError)
            });
        });
    }
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
