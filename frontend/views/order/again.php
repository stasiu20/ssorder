<?php

use yii\helpers\Html;
use frontend\models\Restaurants;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $order \common\models\Order */
$this->title = 'Zamówienie: ' . $order->menu->foodName;
$this->params['breadcrumbs'][] = ['label' => $order->restaurants->restaurantName, 'url' => Url::toRoute(['restaurants/details', 'id' => $order->restaurants->id])];

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
                'action' => Url::to(['/order/uwagi', 'id' => $order->menu->id])
            ])
            ?>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>