<?php

use frontend\assets\RestaurantAsset;
use frontend\helpers\FileServiceViewHelper;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/** @var Restaurants $restaurant */
/** @var Imagesmenu[] $imagesMenu */
$this->title = $restaurant->restaurantName;
$this->params['breadcrumbs'][] = $this->title;
$userName = Yii::$app->user->identity->username;
$formatter = \Yii::$app->formatter;
RestaurantAsset::register($this);
?>
<div class="body-content">
    <div class="row">
        <div class="col-lg-3">
            <h1><?= Html::encode("{$restaurant->restaurantName}"); ?></h1>
            <p>
                <?=
                Html::a('<span class="material-icons">edit</span>', ['restaurants/update', 'id' => $restaurant->id], [
                    'title' => 'Edytuj restaurację',
                ]);
?>
                <?= Html::a('<span class="material-icons">delete</span>', ['restaurants/delete', 'id' => $restaurant->id], ['data-method' => 'post', 'data-confirm' => 'Ar ju siur ju wan tu dileit restauracje i oll pozycje w menue?!?', 'title'=>'Usuń restaurację']) ?>
            </p>
            <div id="react-restaurant-image" data-src="<?= FileServiceViewHelper::getRestaurantImageUrl($restaurant->img_url) ?>" class="img-restaurant"></div>

            <div class="restaurant-details">
                <h5>Numer telefonu:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode("{$restaurant->tel_number}"); ?></h3>
                <h5>Koszt dowozu:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode("{$restaurant->delivery_price}"); ?> zł</h3>
                <h5>Koszt opakowania:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode("{$restaurant->pack_price}"); ?> zł </h3>
            </div>
            <div>
                <?= \common\widgets\VaadinUpload::widget([
                    'target' => \yii\helpers\Url::to(['/upload/image', 'id' => $restaurant->id]),
                    'accept' => 'image/*',
                    'maxFiles' => 1,
                    'formDataName' => 'imagesMenu_url'
                ]) ?>

                <?php if ($imagesMenu) {
                    echo '<h3>Galeria</h3>';
                } ?>
                <?php $galleryData = array_map(function (Imagesmenu $imageMenu) {
                    return [
                        'id' => $imageMenu->id,
                        'url' => FileServiceViewHelper::getMenuImageUrl($imageMenu->imagesMenu_url),
                        'deleteUrl' => Url::toRoute(['restaurants/delete-image', 'id' => $imageMenu->id])
                    ];
                }, $imagesMenu); ?>
                <div data-gallery="<?= Html::encode(Json::encode($galleryData)) ?>" id="react-restaurant-gallery"></div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="info" style="float:left">

                <h3>Menu</h3>
                <p>
                    <?= Html::a('Dodaj pozycję w Menu', ['menu/create', 'id' => $restaurant->id], ['class' => 'btn btn-primary']); ?>
                </p>
            </div>

            <?php if (!empty($menu)): ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'foodName', 'contentOptions' => ['class' => 'text-right text-wrap']],
                        ['attribute' => 'foodInfo', 'contentOptions' => ['class' => 'text-right text-wrap']],
                        ['attribute' => 'foodPrice',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return "$data->foodPrice" . ' ' . 'zł';
                            },
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        ['class' => \common\widgets\grid\ActionMaterialIconColumn::class,
                            'controller' => 'menu',
                            'template' => '{order} {view} {update} {delete}',
                            'buttons' => [
                                'order' => function ($url, $restaurant) {
                                    return Html::a('<span class="material-icons">restaurant</span>', ['order/uwagi', 'id' => $restaurant->id], [
                                                'title' => 'zamów',
                                    ]);
                                },
                            ],
                            'contentOptions' => ['class' => 'text-center',
                            ],
                        ],
                    ],
                ]);
                ?>
            <?php else: ?>
                <p class="nodata"><?php echo 'Ta restauracja nie ma jeszcze menu'; ?></p>

            <?php endif;
            ?>
        </div>

    </div>
</div>

