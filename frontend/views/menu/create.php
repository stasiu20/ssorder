<?php

use yii\helpers\Html;
use frontend\models\Menu;

/* @var $this yii\web\View */
/* @var $model Menu */
/* @var $restaurant \frontend\models\Restaurants */
$this->title = 'Dodaj pozycję w menu';
$this->params['breadcrumbs'][] = [
    'label' => $restaurant->restaurantName,
    'url' => \yii\helpers\Url::toRoute(['site/restaurant', 'id' => $restaurant->id]),
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formMenu', [
        'model' => $model,
    ]) ?>
</div>
