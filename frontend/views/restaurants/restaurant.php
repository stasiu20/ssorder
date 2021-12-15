<?php

use yii\data\DataProviderInterface;
use yii\grid\SerialColumn;
use frontend\assets\RestaurantAsset;
use frontend\helpers\FileServiceViewHelper;
use frontend\models\Imagesmenu;
use frontend\models\Restaurants;
use frontend\modules\apiV1\models\RestaurantDetails;
use frontend\modules\apiV1\models\RestaurantPhoto;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/** @var Restaurants $restaurant */
/** @var Imagesmenu[] $imagesMenu */
/** @var RestaurantDetails $details */
/** @var DataProviderInterface $menuProvider */

$this->title = $details->name;
$this->params['breadcrumbs'][] = $this->title;
$userName = Yii::$app->user->identity->username;
$formatter = \Yii::$app->formatter;
RestaurantAsset::register($this);
?>
<div class="body-content">
    <div class="row">
        <div class="col-lg-3">
            <h1><?= Html::encode($details->name); ?></h1>
            <p>
                <?=
                Html::a('<span class="material-icons">edit</span>', ['restaurants/update', 'id' => $details->id], [
                    'title' => 'Edytuj restaurację',
                ]);
                ?>
                <?= Html::a('<span class="material-icons">delete</span>', ['restaurants/delete', 'id' => $details->id], ['data-method' => 'post', 'data-confirm' => 'Ar ju siur ju wan tu dileit restauracje i oll pozycje w menue?!?', 'title'=>'Usuń restaurację']) ?>
            </p>
            <div id="react-restaurant-image" data-src="<?= $details->logoUrl ?>" class="img-restaurant"></div>

            <div class="restaurant-details">
                <h5>Numer telefonu:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode($details->phoneNumber); ?></h3>
                <h5>Koszt dowozu:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode(number_format($details->deliveryPrice->amount / 100, 2)); ?> zł</h3>
                <h5>Koszt opakowania:</h5>
                <h3 class="restaurant-details__summary"><?= Html::encode(number_format($details->packPrice->amount / 100, 2)); ?> zł </h3>
            </div>
            <div>
                <?= \common\widgets\VaadinUpload::widget([
                    'target' => \yii\helpers\Url::to(['/upload/image', 'id' => $details->id]),
                    'accept' => 'image/*',
                    'maxFiles' => 1,
                    'formDataName' => 'imagesMenu_url'
                ]) ?>

                <?php if (count($details->photos) > 0) {
                    echo '<h3>Galeria</h3>';
                } ?>
                <?php $galleryData = array_map(function (RestaurantPhoto $photo) {
                    return [
                        'id' => $photo->id,
                        'url' => $photo->url,
                        'deleteUrl' => Url::toRoute(['restaurants/delete-image', 'id' => $photo->id])
                    ];
                }, $details->photos); ?>
                <div data-gallery="<?= Html::encode(Json::encode($galleryData)) ?>" id="react-restaurant-gallery"></div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="info" style="float:left">

                <h3>Menu</h3>
                <p>
                    <?= Html::a('Dodaj pozycję w Menu', ['menu/create', 'id' => $details->id], ['class' => 'btn btn-primary']); ?>
                </p>
            </div>

            <?php if (count($details->menu) > 0): ?>
                <?=
                GridView::widget([
                    'dataProvider' => $menuProvider,
                    'summary' => '',
                    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
                    'columns' => [
                        ['class' => SerialColumn::class],
                        ['attribute' => 'name', 'contentOptions' => ['class' => 'text-right text-wrap']],
                        ['attribute' => 'description', 'contentOptions' => ['class' => 'text-right text-wrap']],
                        ['attribute' => 'price',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return number_format(round($data->price->amount / 100, 2), 2) . ' ' . 'zł';
                            },
                            'contentOptions' => ['class' => 'text-right'],
                        ],
                        ['class' => \common\widgets\grid\ActionMaterialIconColumn::class,
                            'controller' => 'menu',
                            'template' => '{order} {view} {update} {delete}',
                            'buttons' => [
                                'order' => function ($url, $menu) {
                                    return Html::a('<span class="material-icons">restaurant</span>', ['order/uwagi', 'id' => $menu->id], [
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
