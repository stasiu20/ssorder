<?php
/** @var \yii\data\BaseDataProvider $dataProvider  */
/** @var \frontend\models\OrdersSummary $summary  */

$this->title = 'Zarządzanie wpłatami';
$form = \yii\bootstrap\ActiveForm::begin();

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'showFooter' => true,
    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'footerOptions' => ['class' => 'no-right-border']
        ],
//            'foodName',
        [ 'attribute' => 'foodName',
            'label' => 'Nazwa Żarcia',
            'format' => 'raw',
            'value' => function($data) {
                $foodName = $data->menu->foodName;
                return "$foodName";
            },
            'contentOptions' => ['class' => 'text-left'],
            'footerOptions' => ['class' => 'no-right-border']
        ],
//            'foodInfo',
        [ 'attribute' => 'foodInfo',
            'label' => 'Info o Żarcia',
            'format' => 'raw',
            'value' => function($data) {
                $foodInfo = $data->menu->foodInfo;
                return "$foodInfo";
            },
            'contentOptions' => ['class' => 'text-left'],
            'footerOptions' => ['class' => 'no-right-border']
        ],
        [
            'attribute' => 'uwagi',
            'footerOptions' => ['class' => 'no-right-border']
        ],
        [
            'attribute' => 'userId',
            'label' => 'Kto',
            'format' => 'raw',
            'value' => function(\common\models\Order $order) {
                return $order->user->username;
            },
            'contentOptions' => ['class' => 'text-right'],
            'footerOptions' => ['class' => 'no-right-border']
        ],
//            'foodPrice',
        [ 'attribute' => 'foodPrice',
            'label' => 'Cena Żarcia',
            'format' => 'raw',
            'value' => function(\common\models\Order $data) use ($summary) {
                $formatter = \Yii::$app->formatter;
                return $formatter->asCurrency(\frontend\helpers\OrderCost::calculateOrderCost(
                    $data,
                    $summary->getDataForRestaurant($data->restaurantId)->numOfOrders,
                    9999) //todo mmo zmienic
                );
            },
            'contentOptions' => ['class' => 'text-right'],
            'footerOptions' => ['class' => 'no-right-border']
        ],
        [
            'class' => \common\widgets\grid\InputColumn::className(),
            'header' => 'Wpłata',
            'attribute' => 'pay_amount',
            'form' => $form,
            'name' => function(\common\models\Order $order) {
                return sprintf('price[%d]', $order->id);
            },
            'footer' => \yii\bootstrap\Html::submitButton('Zapisz'),
            'footerOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'Różnica',
            'contentOptions' => function(\common\models\Order $order) {
                return ['class' => \common\helpers\OrderView::getSettlementCssClass($order)];
            },
            'value' => function(\common\models\Order $order) {
                $formatter = \Yii::$app->formatter;
                return $formatter->asCurrency($order->paymentChange());
            },
        ],
    ],
]);

\yii\bootstrap\ActiveForm::end();