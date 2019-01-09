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
        return stripos($text, 'last') === 0;
    }

    public function execute(Request $request)
    {
        $user = User::getByRocketChatUserId($request->user_id);
        $order = null;

        if ($user) {
            $filters = new OrderFilters();
            $filters->userId = $user->id;
            $filters->status = Order::STATUS_REALIZED;
            $filters->dateTo = date('Y-m-d H:i:s', strtotime('midnight'));

            /** @var Order|null $order */
            $order = OrderSearch::search($filters)
                ->orderBy('data DESC')
                ->limit(1)
                ->one();
        }

        return \Yii::$app->view->render('/rocket-chat/commands/last', ['order' => $order, 'user' => $user]);
    }
}
