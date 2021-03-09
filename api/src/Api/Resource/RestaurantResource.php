<?php

namespace App\Api\Resource;

use App\Restaurant\Entity\Restaurant;
use App\Api\Transformer\RestaurantTransformer;
use League\Fractal\Resource\Collection;

class RestaurantResource
{
    /** @var RestaurantTransformer */
    private $restaurantTransformer;

    public function __construct(RestaurantTransformer $restaurantTransformer)
    {
        $this->restaurantTransformer = $restaurantTransformer;
    }

    /**
     * @param Restaurant[] $restaurants
     *
     * @return Collection
     */
    public function factoryCollection(array $restaurants): Collection
    {
        return new Collection($restaurants, $this->restaurantTransformer);
    }
}
