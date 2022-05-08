<?php

namespace App\Tests\Restaurant\Entity;

use App\Tests\ObjectMother\MenuPositionObjectMother;
use App\Tests\ObjectMother\RestaurantObjectMother;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MenuPositionTest extends TestCase
{
    public function testNormalizeForMeilisearchWithRestaurant(): void
    {
        $menu = MenuPositionObjectMother::default(RestaurantObjectMother::default());
        $data = $menu->normalize($this->createMock(NormalizerInterface::class));

        $expected = [
            'objectID' => 'menu-1',
            'type' => 'food',
            'food' => [
                'name' => $menu->getFoodName(),
                'price' => $menu->getFoodPrice(),
                'info' => $menu->getFoodInfo()
            ],
            'restaurant' => [
                'name' => 'foo',
            ],
            'restaurant_name_search' => 'foo',
            'food_name_search' => $menu->getFoodName(),
        ];

        $this->assertEquals($expected, $data);
    }

    public function testNormalizeForMeilisearchWithoutRestaurant(): void
    {
        $menu = MenuPositionObjectMother::default();
        $data = $menu->normalize($this->createMock(NormalizerInterface::class));

        $expected = [
            'objectID' => 'menu-1',
            'type' => 'food',
            'food' => [
                'name' => $menu->getFoodName(),
                'price' => $menu->getFoodPrice(),
                'info' => $menu->getFoodInfo()
            ],
            'restaurant' => null,
            'restaurant_name_search' => null,
            'food_name_search' => $menu->getFoodName(),
        ];

        $this->assertEquals($expected, $data);
    }
}
