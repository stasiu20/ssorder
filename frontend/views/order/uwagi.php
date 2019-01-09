<?php

use yii\helpers\Html;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurants */
$url = 'site/restaurant?id=' . $model->restaurants[0]['id'];
$this->title = 'Zamówienie: ' . $model->foodName;
$this->params['breadcrumbs'][] = ['label' => $model->restaurants[0]['restaurantName'], 'url' => [$url]];

$this->params['breadcrumbs'][] = 'Uwagi';
?>
<div class="restaurants-update">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <h4>Cena: <?php echo $model->foodPrice ?>zł</h4>
            <?=
            $this->render('_formUwagi', [
                'model' => $model,
                'order' => $order,
            ])
?>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>
