<?php

namespace common\events;

use common\models\Order;
use common\models\User;
use yii\base\Event;

class BeforeRealizedOrdersEvent extends Event
{
    const EVENT_BEFORE_REALIZED_ORDERS = 'beforeRealizedOrders';

    /** @var Order[] */
    public $orders = [];

    /** @var User */
    public $realizedBy = [];

    public static function factory(array $orders, User $user): BeforeRealizedOrdersEvent
    {
        $obj = new static();
        $obj->orders = $orders;
        $obj->realizedBy = $user;
        return $obj;
    }

    public function getTextMessage(): string
    {
        if (!count($this->orders)) {
            return '';
        }

        $order = $this->orders[0];
        return sprintf(
            ":hamburger: :hotdog: :telephone:\nUzytkownik *%s* realizuje zamówienia dla restauracji *%s*.\nJeśli chcesz domówić to pośpiesz się!\n:hamburger: :hotdog: :telephone:",
            $this->realizedBy->username,
            $order->restaurants->restaurantName
        );
    }
}
