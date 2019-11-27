<?php

namespace common\models;

class Payment
{
    /**
     * @param Order[] $orders
     * @param array $postData
     */
    public static function updatePayAmountFromPostData(array $orders, array $postData): void
    {
        foreach ($orders as $order) {
            $payAmount = $order->pay_amount;
            if (isset($postData[$order->id])) {
                $payAmount = $postData[$order->id];
                if ('' === $payAmount) {
                    $payAmount = null;
                } else {
                    $payAmount = (float)$payAmount;
                }
            }
            $order->pay_amount = $payAmount;
        }
    }
}
