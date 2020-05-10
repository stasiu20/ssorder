<?php

namespace common\tests\unit\events\listeners;

use Codeception\Test\Unit;
use common\component\Order;
use common\enums\OrderSource;
use common\events\listeners\NewOrderPrometheus;
use common\events\NewOrderEvent;
use common\services\SSOrderMetrics;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class NewOrderPrometheusTest extends Unit
{
    public function testAttachEvent(): void
    {
        $collectorRegistry = new CollectorRegistry(new InMemory());
        $order = new Order();
        $ssorderMetrics = new SSOrderMetrics($collectorRegistry, 'ssorder');
        $mediator = new NewOrderPrometheus($order, $ssorderMetrics);

        $this->assertFalse($order->hasEventHandlers(NewOrderEvent::EVENT_NEW_ORDER));
        $mediator->mediate();
        $this->assertTrue($order->hasEventHandlers(NewOrderEvent::EVENT_NEW_ORDER));
    }

    public function testMediate(): void
    {
        $collectorRegistry = new CollectorRegistry(new InMemory());
        $orderComponent = new Order();
        $ssorderMetrics = new SSOrderMetrics($collectorRegistry, 'ssorder');
        $mediator = new NewOrderPrometheus($orderComponent, $ssorderMetrics);
        $order = new \common\models\Order();

        $mediator->mediate();
        $this->assertCount(0, $collectorRegistry->getMetricFamilySamples());

        $orderComponent->trigger(
            NewOrderEvent::EVENT_NEW_ORDER,
            NewOrderEvent::factoryFromOrder($order, OrderSource::WEB())
        );
        $this->assertCount(1, $collectorRegistry->getMetricFamilySamples());
        $this->assertCount(1, $collectorRegistry->getMetricFamilySamples()[0]->getSamples());
        $this->assertEquals(1, $collectorRegistry->getMetricFamilySamples()[0]->getSamples()[0]->getValue());
    }
}
