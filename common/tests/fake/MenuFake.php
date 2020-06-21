<?php

namespace common\tests\fake;

use frontend\models\Menu;
use frontend\models\Restaurants;

class MenuFake extends Menu
{
    public function setRestaurant(Restaurants $restaurant): void
    {
        $this->restaurant = $restaurant;
    }
}
