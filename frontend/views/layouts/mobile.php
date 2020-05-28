<?php

/* @var $this \yii\web\View */
/* @var $content string */

/** @var AppVersion $appVersion */
$appVersion = $this->params['appVersion'];

use common\component\UserRestApiMediator;
use mmo\yii2\models\AppVersion;
use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
\frontend\assets\WebpackAsset::register($this);
\frontend\helpers\GoogleAnalyticsHelper::registerJs();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="icon" href="/image/sensisoft.png" type="image/x-icon"/>
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
<body class="d-flex flex-column vh-100">
<?php $this->beginBody() ?>
<header>
    <nav class="navbar navbar-inverse px-4">
        <div class="d-flex flex-column flex-md-row justify-content-sm-between">
            <a class="navbar-brand align-self-center" href="/"><img src="/image/sensilabs-logo.png"></a>
            <h1 class="align-self-center"><?= $this->title ?></h1>
            <p></p>
        </div>
    </nav>
</header>
<div class="container-fluid flex-grow-1 mt-3">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <?= $content ?>
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
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
