<?php

namespace common\tests\unit\services\actions;

use Codeception\Test\Unit;
use common\models\FoodRating;
use common\models\Order;
use common\services\actions\CreateFoodRating;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

class CreateFoodRatingTest extends Unit
{
    public function testCreateRatingWithInvalidOrderStatus(): void
    {
        $userId = 1;
        /** @var IdentityInterface $identity */
        $identity = $this->makeEmpty(IdentityInterface::class, [
            'getId' => function () use ($userId) {
                return $userId;
            }
        ]);

        $order = new Order();
        $order->userId = $userId;
        $order->status = Order::STATUS_NOT_REALIZED;
        $rating = 5;

        $this->expectExceptionMessage('Rating may be assigned only to realized order');
        $service = new CreateFoodRating();
        $service->run($identity, $order, $rating);
    }

    public function testCreateRatingWithWrongUserId(): void
    {
        $userId = 1;
        /** @var IdentityInterface $identity */
        $identity = $this->makeEmpty(IdentityInterface::class, [
            'getId' => function () use ($userId) {
                return $userId;
            }
        ]);

        $order = new Order();
        $order->userId = $userId+1;
        $order->status = Order::STATUS_REALIZED;
        $rating = 5;

        $this->expectExceptionMessage('Cant create rating for order, which belongs to other user');
        $service = new CreateFoodRating();
        $service->run($identity, $order, $rating);
    }

    public function testCreateRatingWhenRatingAlreadyExists(): void
    {
        $userId = 1;
        /** @var IdentityInterface $identity */
        $identity = $this->makeEmpty(IdentityInterface::class, [
            'getId' => function () use ($userId) {
                return $userId;
            }
        ]);

        /** @var Order $order */
        $order = $this->make(Order::class, [
            'userId' => $userId,
            'status' => Order::STATUS_REALIZED,
            'getRating' => function () {
                return $this->makeEmpty(ActiveQuery::class, [
                    'findFor' => function () {
                        return new FoodRating();
                    }
                ]);
            },
        ]);

        $rating = 5;
        $this->expectExceptionMessage('Order has a existing rating');
        $service = new CreateFoodRating();
        $service->run($identity, $order, $rating);
    }

    public function testCreateRatingWhenPassInvalidRatingValue(): void
    {
        $userId = 1;
        /** @var IdentityInterface $identity */
        $identity = $this->makeEmpty(IdentityInterface::class, [
            'getId' => function () use ($userId) {
                return $userId;
            }
        ]);

        /** @var Order $order */
        $order = $this->make(Order::class, [
            'userId' => $userId,
            'status' => Order::STATUS_REALIZED,
            'getRating' => function () {
                return $this->makeEmpty(ActiveQuery::class, [
                    'findFor' => function () {
                        return null;
                    }
                ]);
            },
        ]);

        $rating = 0;
        $this->expectExceptionMessage('Data passed to created food rating are not valid');
        $service = new CreateFoodRating();
        $service->run($identity, $order, $rating);
    }
}
