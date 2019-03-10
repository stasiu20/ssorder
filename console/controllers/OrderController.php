<?php

namespace console\controllers;

use common\models\Order;
use yii\console\Controller;

class OrderController extends Controller
{
    public function actionCancelOrders()
    {
        $today = date('Y-m-d', strtotime('today midnight'));
        /** @var Order[] $orders */
        $orders = Order::find()->andWhere(['status' => Order::STATUS_NOT_REALIZED])
            ->andWhere(['<', 'data', $today])->all();

        foreach ($orders as $order) {
            $order->status = Order::STATUS_CANCELED;
            $order->save(false, ['status']);
        }
    }
}
