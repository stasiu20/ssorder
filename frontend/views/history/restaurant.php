<?php

use frontend\helpers\FileServiceViewHelper;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var Restaurants $restaurant */
/** @var Imagesmenu[] $imagesMenu */

$title = 'Zrealizuj zamówienie dla ' . $restaurant->restaurantName;
$this->title = "$title";
$this->params['breadcrumbs'][] = ['label' => 'Zamówienia', 'url' => ['index/order']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = \Yii::$app->formatter;
?>

<div style="float: left">
    <div><img alt="logo <?= $restaurant->restaurantName ?>" class ="clip-circle restaurant-details__logo" src="<?= FileServiceViewHelper::getRestaurantImageUrl($restaurant->img_url) ?>"></div>
</div>
<div class="info" style="float:left">
    <h6><strong>Info</strong></h6>
    <p>nr tel.: <?= Html::encode("{$restaurant->tel_number}"); ?><br/>
        cena za dowóz: <?= Html::encode("{$formatter->asCurrency($restaurant->delivery_price)}"); ?><br/>
        cena za opakowanie: <?= Html::encode("{$formatter->asCurrency($restaurant->pack_price)}"); ?>
    </p>
</div>

<div style="float:left">

    <?php foreach ($imagesMenu as $imageMenu): ?>
        <div class="responsive">

            <div class="img">
                <a href="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url) ?>" data-lightbox="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url); ?>" data-title="My caption">
                    <img alt="menu photo" class="menuImage" src="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url); ?>"/>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div style="clear: both"></div>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => 'html',
            'attribute' => 'user.username',
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => 'text',
            'attribute' => 'menu.foodName',
            'value' => function (\common\models\Order $order) {
                return $order->getFoodName();
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => ['date', 'php:Y-m-d'],
            'attribute' => 'data'
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => 'html',
            'attribute' => 'price',
            'value' => function (\common\models\Order $order) {
                return Yii::$app->formatter->asCurrency($order->getPrice());
            }
        ],


        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{again}',
            'buttons' => [
                'again' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a(
                        ' <span class="material-icons">restaurant</span>',
                        \yii\helpers\Url::to(['/order/again', 'id' => $model->id]),
                        ['title' => 'Smakowało? Zamów raz jeszcze!']
                    );
                }
            ]
        ],
    ],
]); ?>
