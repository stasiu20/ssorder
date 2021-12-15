<?php

namespace App\Restaurant\Exception;

use App\Contract\Restaurant\Exception\RestaurantNotFoundExceptionInterface;
use RuntimeException;

class RestaurantNotFoundException extends RuntimeException implements RestaurantNotFoundExceptionInterface
{
    public static function restaurantNotExists(int $restaurant): RestaurantNotFoundException
    {
        return new self(sprintf('Restaurant #%d not exists', $restaurant));
    }
}
