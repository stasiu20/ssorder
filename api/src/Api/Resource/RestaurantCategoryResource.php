<?php

namespace App\Api\Resource;

use App\Api\Transformer\RestaurantCategoryTransformer;
use App\Restaurant\Entity\Category;
use League\Fractal\Resource\Collection;

class RestaurantCategoryResource
{
    /**
     * @param Category[] $restaurants
     *
     * @return Collection
     */
    public function factoryCollection(array $restaurants): Collection
    {
        return new Collection($restaurants, new RestaurantCategoryTransformer());
    }
}
