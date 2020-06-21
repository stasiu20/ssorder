<?php

namespace common\tests\unit\resources;

use Codeception\Test\Unit;
use common\models\Order;
use common\resources\OrderResource;
use League\Fractal\Resource\Item;

class OrderResourceTest extends Unit
{
    public function testFactoryItem(): void
    {
        $order = new Order();
        $resource = OrderResource::factoryItem($order);

        $this->assertInstanceOf(Item::class, $resource);
    }
}
