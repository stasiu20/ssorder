<?php

namespace frontend\rocketChat\commands;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\Object;

class LastOrderCommand extends Object implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'last') !== false;
    }

    public function execute(Request $request)
    {
        $user = User::getByRocketChatUserId($request->user_id);
        if (null === $user) {
            return 'Brak integracji z ssorder :/';
        }

        $filters = new OrderFilters();
        $filters->userId = $user->id;
        $filters->status = Order::STATUS_REALIZED;
        $filters->dateTo = date('Y-m-d H:i:s', strtotime('midnight'));

        /** @var Order|null $order */
        $order = OrderSearch::search($filters)
            ->orderBy('data DESC')
            ->limit(1)
            ->one();

        if ($order) {
            $text = 'Twoje ostatnie zamówienie z dnia ' . $order->data . "\n";
            $text .= $this->orderToString($order);
            return $text;
        } else {
            return 'Jeszcze niczego nie zamówiłeś!';
        }

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
