<?php

namespace frontend\rocketChat\commands;

use common\models\User;
use frontend\rocketChat\models\Request;
use yii\base\Object;

class InfoCommand extends Object implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'info') === 0;
    }

    public function execute(Request $request)
    {
        $user = User::getByRocketChatUserId($request->user_id);
        return \Yii::$app->view->render('/rocket-chat/commands/info', [
            'request' => $request,
            'user' => $user
        ]);
    }
}
