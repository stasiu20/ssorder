<?php

namespace common\events;

use common\models\Order;
use yii\base\Event;

class RealizedOrdersEvent extends Event
{
    const EVENT_REALIZED_ORDERS = 'realizedOrders';

    /** @var Order[] */
    public $orders = [];

    /**
     * @param Order[] $orders
     * @return RealizedOrdersEvent
     */
    public static function factoryFromArrayOrders(array $orders)
    {
        $obj = new static();
        $obj->orders = $orders;
        return $obj;
    }

    public function getTextMessage()
    {
        if (!count($this->orders)) {
            return '';
        }

        $order = $this->orders[0];
        return sprintf(
            ":bicyclist::moneybag::moneybag:\nZrealizowano zamowienia dla restauracji *%s*. Sprawdźcie kwotę do zapłaty!\n:bicyclist::moneybag::moneybag:",
            $order->restaurants->restaurantName
        );
    }
}