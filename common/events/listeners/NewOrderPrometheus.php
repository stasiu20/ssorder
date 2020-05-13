<?php

namespace common\events\listeners;

use common\component\Order;
use common\events\NewOrderEvent;
use common\services\SSOrderMetrics;

class NewOrderPrometheus
{
    /**
     * @var Order
     */
    private $_order;
    /**
     * @var SSOrderMetrics
     */
    private $_metrics;

    public function __construct(Order $order, SSOrderMetrics $metrics)
    {
        $this->_order = $order;
        $this->_metrics = $metrics;
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
        $this->_metrics->incrementOrderCounter($event->source);
    }
}
