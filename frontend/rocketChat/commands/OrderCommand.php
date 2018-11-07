<?php

namespace frontend\rocketChat\commands;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\Object;

class OrderCommand extends Object implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'order') !== false;
    }

    public function execute(Request $request)
    {
        $user = User::getByRocketChatUserName($request->user_name);
        if (null === $user) {
            return 'Brak integracji z ssorder :/';
        }

        $filters = new OrderFilters();
        $filters->userId = $user->id;
        $timestamp = time();
        $filters->dateFrom = date('Y-m-d 00:00:00', $timestamp);
        $filters->dateTo = date('Y-m-d H:i:s');
        /** @var Order[] $models */
        $models = OrderSearch::search($filters)->all();

        $text = 'Dzisiejsze twoje zamówienia:' . "\n";
        foreach ($models as $order) {
            $text .= $this->orderToString($order);
        }

        return $text;
    }

    protected function orderToString(Order $order)
    {
        $text = <<<EOS
Zamówienie w restauracji {$order->restaurants->restaurantName} na żarcie {$order->getFoodName()} za {$order->getPrice()}.
UWAGI: {$order->uwagi}
EOS;
        return $text . "\n\n";
    }
}
