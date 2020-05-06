<?php

use yii\helpers\Html;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $model Restaurants */
$url = 'restaurants/' . $model->id;
$this->title = 'Edytuj Restaurację: ' . $model->restaurantName;
$this->params['breadcrumbs'][] = ['label' => $model->restaurantName, 'url' => [$url]];
$this->params['breadcrumbs'][] = 'Edytuj';
?>
<div class="restaurants-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
