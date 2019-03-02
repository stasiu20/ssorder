<?php

namespace common\events;

use common\enums\OrderSource;
use common\models\Order;
use yii\base\Event;

class NewOrderEvent extends Event
{
    const EVENT_NEW_ORDER = 'newOrder';

    /** @var Order */
    public $order;

    /** @var OrderSource|string */
    public $source;

    /**
     * @param Order $order
     * @param string|OrderSource $source
     * @return NewOrderEvent
     */
    public static function factoryFromOrder(Order $order, $source)
    {
        $obj = new static();
        $obj->order = $order;
        $obj->source = $source;
        return $obj;
    }

    public function getTextMessage()
    {
        return sprintf(
            ":hamburger: :hotdog:\nZłożono nowe zamówienie przez *%s* na *%s* w restauracji *%s*.\n:hamburger: :hotdog:",
            $this->order->user->username,
            $this->order->getFoodName(),
            $this->order->restaurants->restaurantName
        );
    }
}
