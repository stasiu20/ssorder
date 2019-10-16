<?php

namespace frontend\rocketChat\commands;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\BaseObject;

class OrderCommand extends BaseObject implements Command
{
    public static function supports($text): bool
    {
        return stripos($text, 'order') === 0;
    }

    public function execute(Request $request): string
    {
        $orders = [];
        $user = User::getByRocketChatUserId($request->user_id);
        if ($user) {
            $filters = new OrderFilters();
            $filters->userId = $user->id;
            $timestamp = time();
            $filters->dateFrom = date('Y-m-d 00:00:00', $timestamp);
            $filters->dateTo = date('Y-m-d H:i:s', strtotime('tomorrow'));
            /** @var Order[] $orders */
            $orders = OrderSearch::search($filters)->all();
        }

        return \Yii::$app->view->render('/rocket-chat/commands/order', ['orders' => $orders, 'user' => $user]);
    }
}
