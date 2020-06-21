<?php

namespace frontend\tests\unit\models;

use frontend\models\Restaurants;

class RestaurantsTest extends \Codeception\Test\Unit
{
    public function testRestaurantIsActive(): void
    {
        $restaurant = new Restaurants();
        $this->assertTrue($restaurant->isActive());
    }

    public function testRestaurantIsNotActive(): void
    {
        $restaurant = new Restaurants();
        $restaurant->softDelete();
        $this->assertFalse($restaurant->isActive());
    }
}
