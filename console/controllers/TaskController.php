<?php

namespace console\controllers;

use common\models\Order;
use common\models\OrderFilters;
use Yii;
use yii\console\Controller;

class TaskController extends Controller
{
    public function actionSetOrderPrice(): void
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
                    $order->menu->foodPrice
                ));
            }
        }
    }

    public function actionSetRealizedBy($userId = 1): void
    {
        /** @var Order[] $orders */
        $orders = Order::findAll(['status' => Order::STATUS_REALIZED, 'realizedBy' => null]);
        foreach ($orders as $order) {
            if (!$order->menu) {
                continue;
            }
            $order->realizedBy = $userId;
            $result = $order->save();
            if (!$result) {
                throw new \RuntimeException(sprintf(
                    'Cant save order #d with %s',
                    $order->id,
                    $order->realizedBy
                ));
            }
        }
    }

    public function actionSetTotalPrice(): void
    {
        /** @var Order[] $orders */
        $orders = Order::findAll(['status' => Order::STATUS_REALIZED, 'total_price' => null]);
        foreach ($orders as $order) {
            if (null === $order->price) {
                continue;
            }

            $midnight = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $order->data)
                ->setTime(0, 0, 0);

            $nextDay = $midnight->add(new \DateInterval('P1D'))
                ->sub(new \DateInterval('PT1S'));

            /** @var Order[] $relizedOrders */
            $relizedOrders = Order::find()->andWhere(['status' => Order::STATUS_REALIZED])
                ->andWhere(['restaurantId' => $order->restaurantId])
                ->andWhere(['BETWEEN', 'data', $midnight->format('Y-m-d H:i:s'), $nextDay->format('Y-m-d H:i:s')])
                ->all();

            $numOfOrders = count($relizedOrders);
            foreach ($relizedOrders as $i => $record) {
                $order->total_price = \frontend\helpers\OrderCost::calculateOrderCost($record, $numOfOrders, $i);
                $order->save(false, ['total_price']);
            }
        }
    }

    public function actionSendMailWithRatingLink(): void
    {
        $filter = new OrderFilters();
        $filter->status = Order::STATUS_REALIZED;
        $filter->dateFrom = (new \DateTime())->sub(new \DateInterval('P1D'))->format('Y-m-d');
        $filter->dateTo = (new \DateTime())->format('Y-m-d');
        $query  = \common\models\OrderSearch::search($filter);

        /** @var Order[] $orders */
        $orders = $query->all();
        foreach ($orders as $order) {
            if ($order->rating) {
                continue;
            }

            \Yii::$app->mailer
                ->compose(
                    [
                        'html' => 'ratingReminder-html',
                        'text' => 'ratingReminder-text'
                    ],
                    ['user' => $order->user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($order->user->email)
                ->setSubject(sprintf('[%s] Oceń zamówienie', Yii::$app->name))
                ->send();
        }
    }
}
