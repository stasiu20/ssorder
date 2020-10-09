<?php

namespace common\resources;

use common\transformers\RestaurantTransformer;
use frontend\models\Restaurants;
use League\Fractal\Resource\Collection;

class RestaurantResource
{
    /**
     * @param Restaurants[] $restaurants
     * @return Collection
     */
    public static function factoryCollection(array $restaurants): Collection
    {
        return new Collection($restaurants, new RestaurantTransformer());
    }
}
