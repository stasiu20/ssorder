<?php

namespace frontend\rocketChat\commands;

use common\enums\OrderSource;
use common\models\Order;
use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\BaseObject;

class ReorderCommand extends BaseObject implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'reorder') === 0;
    }

    public function execute(Request $request)
    {
        $user = User::getByRocketChatUserId($request->user_id);
        if (!$user) {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Brak integracji z ssorder użyj komendy `info`.']);
        }

        $argument = explode(' ', trim($request->text), 3);
        if (count($argument) < 2) {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Nie podałeś numeru zamówienia']);
        }

        $orderId = $argument[1];
        $order = Order::findOne($orderId);
        if ($order) {
            $newOrder = $order->cloneOrder($user->id);
            $newOrder->data = null;
            if (!empty($argument[2])) {
                $newOrder->uwagi = strip_tags($argument[2]);
            }
            $newOrder->status = Order::STATUS_NOT_REALIZED;

            if ($newOrder->validate()) {
                try {
                    /** @var \common\component\Order $orderComponent */
                    $orderComponent = \Yii::$app->order;
                    $orderComponent->addOrder($newOrder, OrderSource::BOT);
                    return \Yii::$app->view->render('/rocket-chat/commands/reorder', ['newOrder' => $newOrder]);
                } catch (\Exception $e) {
                    return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Błąd zapisu']);
                }
            } else {
                return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => 'Błąd walidacji']);
            }
        } else {
            return \Yii::$app->view->render('/rocket-chat/partials/error', ['message' => sprintf('Brak zamówienia `%s`', $orderId)]);
        }
    }
}
