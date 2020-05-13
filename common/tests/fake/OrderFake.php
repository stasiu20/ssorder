<?php

namespace common\tests\fake;

use frontend\models\Menu;
use frontend\models\Restaurants;

class OrderFake extends \common\models\Order
{
    public function setMenu(Menu $menu): void
    {
        $this->menu = $menu;
    }

    public function setRestaurants(Restaurants $restaurant): void
    {
        $this->restaurants = $restaurant;
    }
}
