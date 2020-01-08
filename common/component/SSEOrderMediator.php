<?php

namespace common\component;

use common\events\NewOrderEvent;
use yii\redis\Connection;

class SSEOrderMediator
{
    /** @var Connection */
    private $_redis;

    /**
     * @var Order
     */
    private $_order;

    public function __construct(Connection $connection, Order $order)
    {
        $this->_redis = $connection;
        $this->_order = $order;
    }

    public function mediate(): void
    {
        $this->_order->on(
            NewOrderEvent::EVENT_NEW_ORDER,
            [$this, 'newOrder']
        );
    }

    public function newOrder(NewOrderEvent $event): void
    {
        $this->_redis->publish('sse', $event->getTextMessage());
    }
}
