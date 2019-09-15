<?php

use yii\helpers\Html;
use frontend\models\Restaurants;

/* @var $this yii\web\View */
/* @var $order \common\models\Order */
$url = 'site/restaurant?id=' . $order->restaurants->id;
$this->title = 'Zamówienie: ' . $order->menu->foodName;
$this->params['breadcrumbs'][] = ['label' => $order->restaurants->restaurantName, 'url' => [$url]];

$this->params['breadcrumbs'][] = 'Uwagi';
?>
<div class="restaurants-update">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <h4>Cena: <?php echo $order->menu->foodPrice ?>zł</h4>
            <?=
            $this->render('_formUwagi', [
                'model' => $order->restaurants,
                'order' => $order,
                'action' => \yii\helpers\Url::to(['/order/uwagi', 'id' => $order->menu->id])
            ])
                        ?>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>