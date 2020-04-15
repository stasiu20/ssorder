<?php

namespace common\events\listeners;

use common\component\Order;
use common\events\NewOrderEvent;
use Prometheus\CollectorRegistry;

class NewOrderPrometheus
{
    public function mediate(): void
    {
        $this->getOrderComponent()->on(
            NewOrderEvent::EVENT_NEW_ORDER,
            [$this, 'newOrder']
        );
    }

    public function newOrder(NewOrderEvent $event): void
    {
        $this->getCollectorRegistry()
            ->getOrRegisterCounter(
                $this->getNamespace(),
                'orders_total',
                'Counter of orders',
                ['source']
            )->inc([$event->source]);
    }

    protected function getCollectorRegistry(): CollectorRegistry
    {
        /** @var CollectorRegistry $collectorRegistry */
        $collectorRegistry = \Yii::$container->get(CollectorRegistry::class);
        return $collectorRegistry;
    }

    /**
     * @return Order
     */
    protected function getOrderComponent(): Order
    {
        return \Yii::$app->order;
    }

    protected function getNamespace(): string
    {
        return \Yii::$app->params['prometheus.namespace'];
    }
}
