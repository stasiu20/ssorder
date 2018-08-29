<?php

namespace common\models;


class Payment
{
    /**
     * @param Order[] $orders
     * @param array $postData
     */
    public static function updatePayAmountFromPostData(array $orders, array $postData)
    {
        foreach ($orders as $order) {
            $order->pay_amount = isset($postData[$order->id]) ? $postData[$order->id] : $order->pay_amount;
        }
    }
}
