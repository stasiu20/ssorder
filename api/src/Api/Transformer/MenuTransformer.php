<?php

namespace App\Api\Transformer;

use App\Restaurant\Entity\MenuPosition;
use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract
{
    /**
     * @param MenuPosition $data
     *
     * @return array{id: int, restaurantId: int, foodName: string, foodInfo: string, foodPrice: float}
     */
    public function transform(MenuPosition $data): array
    {
        return [
            'id' => $data->getId(),
            'restaurantId' => $data->getRestaurant()->getId(),
            'foodName' => $data->getFoodName(),
            'foodInfo' => $data->getFoodInfo(),
            'foodPrice' => (float) $data->getFoodPrice(),
        ];
    }
}
