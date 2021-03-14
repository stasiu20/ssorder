<?php

namespace App\Tests\Api\Transformer;

use App\Api\Transformer\MenuTransformer;
use App\Restaurant\Entity\MenuPosition;
use App\Tests\ObjectMother\MenuPositionObjectMother;
use App\Tests\ObjectMother\RestaurantObjectMother;
use PHPUnit\Framework\TestCase;

class MenuTransformerTest extends TestCase
{
    /**
     * @dataProvider menuProvider
     *
     * @param MenuPosition $menuPosition
     */
    public function testTransform(MenuPosition $menuPosition): void
    {
        $obj = new MenuTransformer();
        $array = $obj->transform($menuPosition);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('restaurantId', $array);
        $this->assertArrayHasKey('foodInfo', $array);
        $this->assertArrayHasKey('foodName', $array);
        $this->assertArrayHasKey('foodPrice', $array);

        $this->assertEquals($menuPosition->getId(), $array['id']);
        $this->assertEquals($menuPosition->getRestaurantId(), $array['restaurantId']);
        $this->assertEquals($menuPosition->getFoodInfo(), $array['foodInfo']);
        $this->assertEquals($menuPosition->getFoodName(), $array['foodName']);
        $this->assertEquals($menuPosition->getFoodPrice(), $array['foodPrice']);
    }

    public function menuProvider(): array
    {
        $restaurant = MenuPositionObjectMother::create(
            [
                'id' => 1,
                'restaurant' => RestaurantObjectMother::create(['id' => 999]),
                'foodInfo' => 'foo',
                'foodName' => 'bar',
                'foodPrice' => 1.99,
            ]
        );

        return [[$restaurant]];
    }
}
