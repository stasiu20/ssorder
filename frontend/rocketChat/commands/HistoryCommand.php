<?php

namespace frontend\rocketChat\commands;

use common\models\Order;
use common\models\OrderFilters;
use common\models\OrderSearch;
use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\BaseObject;

class HistoryCommand extends BaseObject implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'history') === 0;
    }

    public function execute(Request $request)
    {
        $argument = explode(' ', $request->text, 3);
        if (count($argument) < 2) {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Nie podałeś daty']);
        }

        $arg = $argument[1];
        $date = strtotime($arg);
        if (false === $date) {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Niepoprawny format daty.']);
        }

        $dateTo = empty($argument[2]) ? strtotime('tomorrow', $date) : strtotime($argument[2]);
        if (false === $dateTo) {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Niepoprawny format daty do.']);
        }

        $orders = [];
        $user = User::getByRocketChatUserId($request->user_id);
        if ($user) {
            $filters = new OrderFilters();
            $filters->userId = $user->id;
            $filters->status = Order::STATUS_REALIZED;
            $filters->dateFrom = date('Y-m-d 00:00:00', $date);
            $filters->dateTo = date('Y-m-d H:i:s', $dateTo);
            /** @var Order[] $orders */
            $orders = OrderSearch::search($filters)->all();
        }

        return \Yii::$app->view->render('/rocket-chat/commands/history', [
            'orders' => $orders,
            'user' => $user,
            'date' => \Yii::$app->formatter->asDate($date, 'short'),
            'dateTo' => \Yii::$app->formatter->asDate($dateTo, 'short')
        ]);
    }
}
