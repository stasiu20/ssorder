<?php

use frontend\assets\OrderRealiseAsset;
use frontend\helpers\FileServiceViewHelper;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

/** @var Restaurants $restaurant */
/** @var Imagesmenu[] $imagesMenu */

$title = 'Zrealizuj zamówienie dla ' . $restaurant->restaurantName;
$this->title = "$title";
$this->params['breadcrumbs'][] = ['label' => 'Zamówienia', 'url' => Url::to(['order/index'])];
$this->params['breadcrumbs'][] = $this->title;
$formatter = \Yii::$app->formatter;

OrderRealiseAsset::register($this);
?>

<div class="d-flex flex-row">
    <div class ="img-restaurant"><img class ="img-circle" src="<?= FileServiceViewHelper::getRestaurantImageUrl($restaurant->img_url) ?>"></div>
    <div class="ml-4">
        <h6><b>Info</b></h6>
        <p>nr tel.: <?= Html::encode("{$restaurant->tel_number}"); ?><br/>
            cena za dowóz: <?= Html::encode("{$formatter->asCurrency($restaurant->delivery_price)}"); ?><br/>
            cena za opakowanie: <?= Html::encode("{$formatter->asCurrency($restaurant->pack_price)}"); ?>
        </p>
    </div>
</div>

<?php $galleryData = array_map(function (Imagesmenu $imageMenu) {
    return [
        'id' => $imageMenu->id,
        'url' => FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url),
        'deleteUrl' => Url::toRoute(['restaurants/delete-image', 'id' => $imageMenu->id])
    ];
}, $imagesMenu); ?>
<div data-gallery="<?= Html::encode(Json::encode($galleryData)) ?>" id="react-restaurant-gallery"></div>
<br />

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
//            'foodName',
        [ 'attribute' => 'foodName',
            'label' => 'Nazwa Żarcia',
            'format' => 'raw',
            'value' => function ($data) {
                $foodName = $data->menu->foodName;
                return "$foodName";
            },
            'contentOptions' => ['class' => 'text-left text-wrap'],
        ],
//            'foodInfo',
        [ 'attribute' => 'foodInfo',
            'label' => 'Info o Żarcia',
            'format' => 'raw',
            'value' => function ($data) {
                $foodInfo = $data->menu->foodInfo;
                return "$foodInfo";
            },
            'contentOptions' => ['class' => 'text-left text-wrap'],
        ],
        'uwagi',
        [
            'attribute' => 'userId',
            'label' => 'Kto',
            'format' => 'raw',
            'value' => function (\common\models\Order $order) {
                return $order->user->username;
            },
            'contentOptions' => ['class' => 'text-right'],
        ],
//            'foodPrice',
        [ 'attribute' => 'foodPrice',
            'label' => 'Cena Żarcia',
            'format' => 'raw',
            'value' => function (\common\models\Order $data) {
                $foodPrice = $data->getPrice();
                return "$foodPrice" . ' ' . 'zł';
            },
            'contentOptions' => ['class' => 'text-right'],
        ],
        [ 'attribute' => 'status',
            'value' => function ($data) {
                if ($data->status == 0) {
                    $status = 'do realizacji';
                } else {
                    $status = 'zrealizowano';
                }

                return $status;
            },
            'contentOptions' => function ($model, $key, $index, $column) {



                if ($model->status == 0) {
                    $background = ['class' => 'text-right', 'style' => 'background-color: red'];
                } else {
                    $background = ['class' => 'text-right', 'style' => 'background-color: green'];
                }

                return $background;
            }
                ],
            ],
        ]);
?>
<div class="text-right">
    <?= Html::a('Zrealizuj', ["order-completed?id=$restaurant->id"], ['class' => 'btn btn-primary'], ['title' => 'zamów',]); ?>
</div>
