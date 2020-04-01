<?php

namespace common\jobs;

use common\models\Order;
use common\models\OrderFilters;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class RateOrders extends BaseObject implements JobInterface
{
    /** @var string Date format Y-m-d */
    public $date;

    public function execute($queue)
    {
        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', $this->date);

        $filter = new OrderFilters();
        $filter->status = Order::STATUS_REALIZED;
        $filter->dateFrom = ($dateTime)->sub(new \DateInterval('P1D'))->format('Y-m-d');
        $filter->dateTo = ($dateTime)->format('Y-m-d');
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
                    ['user' => $order->user, 'order' => $order]
                )
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setTo($order->user->email)
                ->setSubject(sprintf('[%s] Oceń zamówienie', \Yii::$app->name))
                ->send();

            \Yii::info(
                sprintf("Send notify email to %s for order %d\n", $order->user->email, $order->id),
                'application.tasks'
            );
        }
    }
}
