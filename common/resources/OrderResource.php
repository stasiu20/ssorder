<?php

namespace common\resources;

use common\models\Order;
use common\transformers\OrderTransformer;
use League\Fractal\Resource\Item;

class OrderResource
{
    public static function factoryItem(Order $order): Item
    {
        return new Item($order, new OrderTransformer());
    }
}
