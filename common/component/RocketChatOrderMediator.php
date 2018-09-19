<?php

namespace common\component;

use common\events\BeforeRealizedOrdersEvent;
use common\events\NewOrderEvent;
use common\events\RealizedOrdersEvent;
use yii\base\Component;

class RocketChatOrderMediator extends Component
{
    public function mediate()
    {
        $this->getOrderComponent()->on(
            NewOrderEvent::EVENT_NEW_ORDER,
            [$this, 'newOrder']
        );

        $this->getOrderComponent()->on(
            RealizedOrdersEvent::EVENT_REALIZED_ORDERS,
            [$this, 'realizedOrders']
        );

        $this->getOrderComponent()->on(
            BeforeRealizedOrdersEvent::EVENT_BEFORE_REALIZED_ORDERS,
            [$this, 'beforeRealizedOrders']
        );
    }

    public function newOrder(NewOrderEvent $event)
    {
        $this->getRocketChatComponent()->sendText($event->getTextMessage());
    }

    public function realizedOrders(RealizedOrdersEvent $event)
    {
        $this->getRocketChatComponent()->sendText($event->getTextMessage());
    }

    public function beforeRealizedOrders(BeforeRealizedOrdersEvent $event)
    {
        $this->getRocketChatComponent()->sendText($event->getTextMessage());
    }

    protected function getRocketChatComponent()
    {
        /** @var RocketChat $rocketChat */
        $rocketChat = \Yii::$app->rocketChat;
        return $rocketChat;
    }

    /**
     * @return Order
     */
    protected function getOrderComponent()
    {
        $order = \Yii::$app->order;
        return $order;
    }
}
