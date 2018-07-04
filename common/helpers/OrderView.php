<?php

namespace common\helpers;

use common\models\Order;

class OrderView
{
    public static function getSettlementCssClass(Order $order)
    {
        return $order->paymentChange() > 0 ? 'text-danger' : 'text-success';
    }
}
