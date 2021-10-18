<?php

namespace common\component;

use common\events\BeforeRealizedOrdersEvent;
use common\events\NewOrderEvent;
use common\events\RealizedOrdersEvent;
use yii\base\Component;

class RocketChatOrderMediator extends Component
{
    public function mediate(): void
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

    public function newOrder(NewOrderEvent $event): void
    {
        $this->getRocketChatComponent()->sendText($event->getTextMessage());
    }

    public function realizedOrders(RealizedOrdersEvent $event): void
    {
        $text = $event->getTextMessage();
        if (!empty($text)) {
            $this->getRocketChatComponent()->sendText($text);
        }
    }

    public function beforeRealizedOrders(BeforeRealizedOrdersEvent $event): void
    {
        $text = $event->getTextMessage();
        if (!empty($text)) {
            $this->getRocketChatComponent()->sendText($text);
        }
    }

    protected function getRocketChatComponent(): RocketChat
    {
        /** @var RocketChat $rocketChat */
        $rocketChat = \Yii::$app->rocketChat;

        return $rocketChat;
    }

    /**
     * @return Order
     */
    protected function getOrderComponent(): Order
    {
        $order = \Yii::$app->order;
        return $order;
    }
}
