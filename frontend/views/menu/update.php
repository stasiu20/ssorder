<?php

use frontend\models\Restaurants;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \frontend\models\Menu */
/* @var $restaurant Restaurants */

$url = $restaurant->id;
$restaurantName = $restaurant->restaurantName;

$this->title = 'Zmień pozycję w Menu: ' . $model->foodName;
$this->params['breadcrumbs'][] = ['label' => "$restaurantName", 'url' => ['restaurant', 'id'=>$url]];
$this->params['breadcrumbs'][] = ['label' => $model->foodName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'UpdateMenu';
?>
<div class="restaurants-update">
    <div class="row">
<div class="col-lg-2"></div>
    <div class="col-lg-8">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formMenu', [
        'model' => $model,
    ]) ?>
    </div>
    </div>

</div>