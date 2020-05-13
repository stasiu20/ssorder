<?php

namespace common\tests\unit\component;

use Codeception\Test\Unit;
use common\component\Order;
use common\component\SSEOrderMediator;
use common\enums\OrderSource;
use common\events\NewOrderEvent;
use yii\redis\Connection;

class SSEOrderMediatorTest extends Unit
{
    public function testMediate(): void
    {
        $redisMock = $this->createMock(Connection::class);
        $orderComponent = new Order();

        $this->assertFalse($orderComponent->hasEventHandlers(NewOrderEvent::EVENT_NEW_ORDER));
        $mediator = new SSEOrderMediator($redisMock, $orderComponent);
        $mediator->mediate();
        $this->assertTrue($orderComponent->hasEventHandlers(NewOrderEvent::EVENT_NEW_ORDER));
    }

    public function testNewOrderEvent(): void
    {
        $redisMock = $this->getMockBuilder(Connection::class)->addMethods(['publish'])->getMock();
        $redisMock->expects(static::once())
            ->method('publish')
            ->with($this->equalTo('sse'), $this->isType('string'));

        $orderActiveRecordMock = $this->createMock(\common\models\Order::class);
        $orderActiveRecordMock->expects(static::once())
            ->method('save')
            ->willReturn(true);
        $orderActiveRecordMock->expects(static::once())
            ->method('getFoodName')
            ->willReturn('Foo');
        $orderActiveRecordMock->expects(static::exactly(2))
            ->method('__get')
            ->willReturn((object)['username' => 'Bar'], (object)['restaurantName' => 'FooBar']);

        $orderComponent = new Order();
        $mediator = new SSEOrderMediator($redisMock, $orderComponent);
        $mediator->mediate();
        $orderComponent->addOrder($orderActiveRecordMock, OrderSource::WEB());
    }
}
