<?php

use yii\helpers\Html;
use frontend\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */



$this->title = 'Dodaj pozycję w menu';
$this->params['breadcrumbs'][] = ['label' => $restaurant->restaurantName, 'url' => ['restaurant', 'id' => $restaurant->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-create">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-6">

            <h1><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_formMenu', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
