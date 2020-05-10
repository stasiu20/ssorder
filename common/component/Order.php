<?php

namespace common\component;

use common\enums\OrderSource;
use common\events\NewOrderEvent;
use yii\base\Component;

class Order extends Component
{
    /**
     * @param \common\models\Order $order
     * @param OrderSource $source
     * @return bool
     */
    public function addOrder(\common\models\Order $order, OrderSource $source)
    {
        $result = $order->save();
        if (false === $result) {
            return false;
        }

        $this->trigger(
            NewOrderEvent::EVENT_NEW_ORDER,
            NewOrderEvent::factoryFromOrder($order, $source)
        );

        return true;
    }
}
