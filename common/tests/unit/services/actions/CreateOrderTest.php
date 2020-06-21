<?php

namespace common\tests\unit\services\actions;

use Codeception\Test\Unit;
use common\component\Order as OrderComponent;
use common\enums\OrderSource;
use common\models\Order;
use common\repositories\MenuRepository;
use common\services\actions\CreateOrder;
use common\tests\fake\MenuFake;
use frontend\models\Restaurants;
use frontend\modules\apiV1\models\request\CreateOrderRequest;
use yii\web\IdentityInterface;

class CreateOrderTest extends Unit
{
    public function testRun(): void
    {
        $userId = 23;
        $orderSource = OrderSource::API();

        $menu = new MenuFake();
        $menu->id = 34;
        $menu->restaurant = new Restaurants();
        $menu->restaurant->id = 54;
        $menu->restaurantId = $menu->restaurant->id;

        $orderRequest = new CreateOrderRequest();
        $orderRequest->foodId = $menu->id;
        $orderRequest->remarks = 'foo';

        $mock = $this->createMock(OrderComponent::class);
        $mock->expects(self::once())
            ->method('addOrder')
            ->with($this->isInstanceOf(Order::class), $this->equalTo($orderSource));

        $mockRepository = $this->createMock(MenuRepository::class);
        $mockRepository->expects(self::once())
            ->method('findOne')
            ->with($menu->id)
            ->willReturnReference($menu);

        $stubUser = $this->createMock(IdentityInterface::class);
        $stubUser->method('getId')->willReturn($userId);

        $service = new CreateOrder($mock, $mockRepository);
        $order = $service->run($orderRequest, $orderSource, $stubUser);

        $this->assertEquals($orderRequest->remarks, $order->uwagi);
        $this->assertSame($userId, $order->userId);
        $this->assertEquals($orderRequest->foodId, $order->foodId);
        $this->assertEquals($menu->restaurantId, $order->restaurantId);
        $this->assertEquals(Order::STATUS_NOT_REALIZED, $order->status);
    }

    public function testRunMenuNotFound(): void
    {
        $orderRequest = new CreateOrderRequest();
        $orderRequest->foodId = 999;
        $orderRequest->remarks = 'foo';

        $mock = $this->createMock(OrderComponent::class);

        $mockRepository = $this->createMock(MenuRepository::class);
        $mockRepository->expects(self::once())
            ->method('findOne')
            ->willReturn(null);

        $stubUser = $this->createMock(IdentityInterface::class);

        $service = new CreateOrder($mock, $mockRepository);
        $this->expectException(\LogicException::class);
        $service->run($orderRequest, OrderSource::BOT(), $stubUser);
    }

    public function testRunRestaurantIsNotActive(): void
    {
        $orderRequest = new CreateOrderRequest();
        $orderRequest->foodId = 999;
        $orderRequest->remarks = 'foo';

        $menu = new MenuFake();
        $menu->id = 34;
        $menu->restaurant = new Restaurants();
        $menu->restaurant->softDelete();
        $menu->restaurant->id = 54;
        $menu->restaurantId = $menu->restaurant->id;

        $mock = $this->createMock(OrderComponent::class);

        $mockRepository = $this->createMock(MenuRepository::class);
        $mockRepository->expects(self::once())
            ->method('findOne')
            ->willReturnReference($menu);

        $stubUser = $this->createMock(IdentityInterface::class);

        $service = new CreateOrder($mock, $mockRepository);
        $this->expectException(\LogicException::class);
        $service->run($orderRequest, OrderSource::BOT(), $stubUser);
    }
}
