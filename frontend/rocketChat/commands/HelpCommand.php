<?php

namespace frontend\rocketChat\commands;

use frontend\rocketChat\models\Request;
use yii\base\BaseObject;

class HelpCommand extends BaseObject implements Command
{
    public static function supports($text): bool
    {
        return stripos($text, 'help') === 0;
    }

    public function execute(Request $request): string
    {
        return \Yii::$app->view->render('/rocket-chat/commands/help');
    }
}
