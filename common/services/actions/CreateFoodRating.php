<?php

namespace common\services\actions;

use common\models\FoodRating;
use common\models\Order;
use yii\web\IdentityInterface;

class CreateFoodRating
{
    public function run(IdentityInterface $user, Order $order, int $rating, string $review = null): void
    {
        $foodRating = new FoodRating();
        $foodRating->user_id = $user->getId();
        $foodRating->order_id = $order->id;
        $foodRating->date = (new \DateTime())->format('Y-m-d H:i:s');
        $foodRating->rating = $rating;
        $foodRating->review = $review;

        if (Order::STATUS_REALIZED !== $order->status) {
            throw new \LogicException('Rating may be assigned only to realized order');
        }

        if ($order->rating) {
            throw new \LogicException('Order has a existing rating');
        }

        if ($order->userId !== $user->getId()) {
            throw new \LogicException('Cant create rating for order, which belongs to other user');
        }

        if (!$foodRating->validate()) {
            throw new \LogicException('Data passed to created food rating are not valid');
        }
        $foodRating->save();
    }
}
