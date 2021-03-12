<?php

namespace App\Tests\ObjectMother;

use App\Api\Resource\RestaurantResource;

class RestaurantResourceObjectMother
{
    public static function create(): RestaurantResource
    {
        return new RestaurantResource(
            RestaurantTransformerObjectMother::createWithPublicUrl('https://cdn.example.com')
        );
    }
}
