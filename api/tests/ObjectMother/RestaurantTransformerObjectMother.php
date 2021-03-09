<?php

namespace App\Tests\ObjectMother;

use App\Api\Transformer\RestaurantTransformer;

class RestaurantTransformerObjectMother
{
    public static function createWithPublicUrl(string $publicUrl): RestaurantTransformer
    {
        return new RestaurantTransformer(FileServiceObjectMother::createWithPublicUrl($publicUrl));
    }
}
