<?php

namespace common\component;

use baibaratsky\yii\google\analytics\MeasurementProtocol;
use common\events\NewOrderEvent;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
use yii\base\Component;

class GAOrderMediator extends Component
{
    public function mediate()
    {
        $this->getOrderComponent()->on(
            NewOrderEvent::EVENT_NEW_ORDER,
            [$this, 'newOrder']
        );
    }

    public function newOrder(NewOrderEvent $event)
    {
        $this->getGoogleAnalyticsObject()
            ->setEventCategory('NewOrder')
            ->setEventAction($event->source)
            ->sendEvent();
    }

    protected function getGoogleAnalyticsObject()
    {
        /** @var Analytics $ga */
        $ga = \Yii::$container->get(\TheIconic\Tracking\GoogleAnalytics\Analytics::class);
        return $ga;
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
