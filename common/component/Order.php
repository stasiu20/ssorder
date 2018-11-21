<?php

namespace common\component;

use common\events\NewOrderEvent;
use yii\base\Component;

class Order extends Component
{
    public function addOrder(\common\models\Order $order)
    {
        $result = $order->save();
        if (false === $result) {
            return false;
        }

        $this->trigger(
            NewOrderEvent::EVENT_NEW_ORDER,
            NewOrderEvent::factoryFromOrder($order)
        );

        return true;
    }
}
