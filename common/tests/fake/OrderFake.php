<?php

namespace common\tests\fake;

use frontend\models\Menu;

class OrderFake extends \common\models\Order
{
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
    }
}
