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
        $text = <<<EOS
Wiadomość od $request->user_name, id rocketchat ($request->user_id)
EOS;
        $text .= "\n";

        $user = User::getByRocketChatUserId($request->user_id);
        if (null === $user) {
            $text .= 'Nie masz integracji między ssorder a rocketchat :/';
        } else {
            $text .= 'Twój login w ssorder to ' . $user->username;
        }

        return $text;
    }
}
