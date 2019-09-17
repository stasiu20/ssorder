<?php

namespace common\helpers;

use common\models\Order;
use yii\i18n\Formatter;

class OrderView
{
    /**
     * @param float|null $amount
     * @return string
     */
    public static function getSettlementCssClass($amount): string
    {
        return $amount > 0 ? 'text-danger' : 'text-success';
    }

    public static function getOrderChangeTitle(Order $order, Formatter $formatter = null): ?string
    {
        if (null === $formatter) {
            $formatter = \Yii::$app->formatter;
        }

        $change = $order->paymentChange($order->total_price);
        if ($change > 0) {
            return sprintf(
                'Do zapłaty %s z %s',
                $formatter->asCurrency($change),
                $formatter->asCurrency($order->total_price)
            );
        } elseif ($change < 0) {
            return sprintf(
                'Nadpłata %s',
                $formatter->asCurrency(abs($change))
            );
        } else {
            return sprintf(
                'Rozliczone'
            );
        }
    }
}
