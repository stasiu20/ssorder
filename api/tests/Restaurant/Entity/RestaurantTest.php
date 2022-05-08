<?php

namespace App\Tests\Restaurant\Entity;

use App\Tests\ObjectMother\RestaurantObjectMother;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RestaurantTest extends TestCase
{
    public function testNormalizeForMeilisearch(): void
    {
        $restaurant = RestaurantObjectMother::default();
        $data = $restaurant->normalize($this->createMock(NormalizerInterface::class));

        $expected = [
            'objectID' => 'restaurant-1',
            'type' => 'restaurant',
            'food' => null,
            'restaurant' => [
                'name' => 'foo',
            ],
            'restaurant_name_search' => 'foo',
            'food_name_search' => null,
        ];

        $this->assertEquals($expected, $data);
    }
}
