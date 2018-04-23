<?php

namespace console\controllers;

use common\models\Order;
use yii\console\Controller;

class TaskController extends Controller
{
    public function actionSetOrderPrice()
    {
        /** @var Order[] $orders */
        $orders = Order::findAll(['status' => Order::STATUS_REALIZED, 'price' => null]);
        foreach ($orders as $order) {
            if (!$order->menu) {
                continue;
            }
            $order->price = $order->menu->foodPrice;
            $result = $order->save();
            if (!$result) {
                throw new \RuntimeException(sprintf(
                    'Cant save order #d with %s',
                    $order->id,
                    $order->menu->foodPrice)
                );
            }
        }
    }
}
