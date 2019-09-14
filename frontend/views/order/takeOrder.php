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
    <div class ="img-restaurant"><img class ="img-circle" src="/image/<?= FileServiceViewHelper::getRestaurantImageUrl($restaurant->img_url) ?>"></div>
</div>
<div class="info" style="float:left">
    <h6><b>Info</b></h6>
    <p>nr tel.: <?= Html::encode("{$restaurant->tel_number}"); ?><br/>
        cena za dowóz: <?= Html::encode("{$formatter->asCurrency($restaurant->delivery_price)}"); ?><br/>
        cena za opakowanie: <?= Html::encode("{$formatter->asCurrency($restaurant->pack_price)}"); ?>
    </p>
</div>

<div class="menuImg" style="float:left">

    <?php foreach ($imagesMenu as $imageMenu): ?>
        <div class="responsive">

            <div class="img">
                <a href="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url); ?>" data-lightbox="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url); ?>"  data-title="My caption">
                    <img class="menuImage" src="<?= FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url); ?>"/>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div style="clear: both"></div>
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
            'contentOptions' => ['class' => 'text-left'],
        ],
//            'foodInfo',
        [ 'attribute' => 'foodInfo',
            'label' => 'Info o Żarcia',
            'format' => 'raw',
            'value' => function ($data) {
                $foodInfo = $data->menu->foodInfo;
                return "$foodInfo";
            },
            'contentOptions' => ['class' => 'text-left'],
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
        <div style="float: right">
        <?= Html::a('Zrealizuj', ["order-completed?id=$restaurant->id"], ['class' => 'btn btn-primary'], ['title' => 'zamów',]); ?>
</div>


<!--['class' => 'yii\grid\ActionColumn',
            'template' => '{zrealizuj}',
            'buttons' => [
                'zrealizuj' => function($url, $restaurant) {
                    if ($restaurant->status === 0) {
                        //TO DOO action w kontrolerze do zmiany statusu
                        return Html::a('Zrealizuj', ["restaurant"], ['class' => 'btn btn-primary'], ['title' => 'zamów',
                        ]);
                    }
                },
                    ],
                    'contentOptions' => ['class' => 'text-center',
                    ],
                ],-->