<?php

namespace App\Contract\Restaurant;

use App\Contract\Restaurant\Exception\RestaurantNotFoundExceptionInterface;

interface RestaurantDetailsProviderInterface
{
    /**
     * @param int $restaurantId
     *
     * @throws RestaurantNotFoundExceptionInterface
     *
     * @return RestaurantDetailsInterface
     */
    public function getDetails(int $restaurantId): RestaurantDetailsInterface;
}
