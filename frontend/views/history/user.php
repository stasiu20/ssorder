<?php
/** @var $dataProvider \yii\data\DataProviderInterface */
/** @var $searchModel \common\models\OrderFilters */

use common\models\Order; ?>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => 'html',
            'attribute' => 'restaurantId',
            'filter' => \frontend\models\Restaurants::restaurantsAsArray(),
            'value' => function (\common\models\Order $order) {
                return \yii\helpers\Html::a($order->getRestaurantName(), \yii\helpers\Url::to(['site/restaurant', 'id' => $order->restaurantId]));
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'format' => 'text',
            'attribute' => 'foodName',
            'value' => function (\common\models\Order $order) {
                return $order->getFoodName();
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'attribute' => 'date',
            'filter' => \common\widgets\DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date',
                'pluginOptions' => \frontend\helpers\DateRangePickerHelper::getDefaultWidgetOptions(),
            ]),
            'value' => function (\common\models\Order $order) {
                return Yii::$app->formatter->asDate($order->data, 'php:Y-m-d');
            }
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
            'template' => '{again} {rating}',
            'buttons' => [
                'again' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a(
                        ' <span class="material-icons">restaurant</span>',
                        \yii\helpers\Url::to(['/order/again', 'id' => $model->id]),
                        ['title' => 'Smakowało? Zamów raz jeszcze!']
                    );
                },
                'rating' => function ($url, Order $model, $key) {
                    if ($model->rating) {
                        return '';
                    }

                    return \yii\helpers\Html::a(
                        ' <span class="material-icons">thumb_up</span>',
                        \yii\helpers\Url::to(['/rating/order', 'orderId' => $model->id]),
                        ['title' => 'Oceń!']
                    );
                }
            ]
        ],
    ],
]);
