<?php

namespace common\helpers;

use common\models\Order;
use yii\i18n\Formatter;

class OrderView
{
    public static function getSettlementCssClass($amount)
    {
        return $amount > 0 ? 'text-danger' : 'text-success';
    }

    public static function getOrderChangeTitle(Order $order, $totalCost, Formatter $formatter = null)
    {
        if (null === $formatter) {
            $formatter = \Yii::$app->formatter;
        }

        return sprintf(
            'Zostało %s z %s',
            $formatter->asCurrency($order->paymentChange($totalCost)),
            $formatter->asCurrency($totalCost)
        );
    }
}
