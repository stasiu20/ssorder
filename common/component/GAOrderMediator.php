<?php

namespace common\component;

use baibaratsky\yii\google\analytics\MeasurementProtocol;
use common\events\NewOrderEvent;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
use yii\base\Component;

class GAOrderMediator extends Component
{
    public function mediate(): void
    {
        $this->getOrderComponent()->on(
            NewOrderEvent::EVENT_NEW_ORDER,
            [$this, 'newOrder']
        );
    }

    public function newOrder(NewOrderEvent $event): void
    {
        $this->getGoogleAnalyticsObject()
            ->setEventCategory('NewOrder')
            ->setEventAction($event->source)
            ->sendEvent();
    }

    protected function getGoogleAnalyticsObject(): Analytics
    {
        /** @var Analytics $ga */
        $ga = \Yii::$container->get(\TheIconic\Tracking\GoogleAnalytics\Analytics::class);
        return $ga;
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
