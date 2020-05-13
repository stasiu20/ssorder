<?php

namespace common\services;

use Prometheus\CollectorRegistry;

class SSOrderMetrics
{
    /**
     * @var CollectorRegistry
     */
    private $_collectorRegistry;
    /**
     * @var string
     */
    private $_namespace;

    public function __construct(CollectorRegistry $collectorRegistry, string $namespace)
    {
        $this->_collectorRegistry = $collectorRegistry;
        $this->_namespace = $namespace;
    }

    public function incrementOrderCounter(string $source): void
    {
        $this->_collectorRegistry->getOrRegisterCounter(
            $this->_namespace,
            'orders_total',
            'Counter of orders',
            ['source']
        )->inc([$source]);
    }
}
