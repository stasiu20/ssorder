<?php

use yii\helpers\Html;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurants */
$url = 'site/restaurant?id=' . $model->id;
$this->title = 'Edytuj Restaurację: ' . $model->restaurantName;
$this->params['breadcrumbs'][] = ['label' => $model->restaurantName, 'url' => [$url]];
//$this->params['breadcrumbs'][] = ['label' => $model->restaurantName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edytuj';
?>
<div class="restaurants-update">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <h1><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
