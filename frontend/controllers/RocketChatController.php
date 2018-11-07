<?php

namespace frontend\controllers;

use frontend\rocketChat\filters\AuthToken;
use frontend\rocketChat\models\Request;
use yii\rest\Controller;

class RocketChatController extends Controller
{
    public function behaviors()
    {
        $behaviours = parent::behaviors();
        $behaviours['auth'] = [
            'class' => AuthToken::className(),
            'token' => \Yii::$app->params['rocketChatBotToken']
        ];
        return $behaviours;
    }

    public function actionIndex()
    {
        $request = \Yii::$app->request->getBodyParams();
        $message = Request::factoryFromArray($request);

        if (!$message->validate()) {
            return $message;
        }

        $command = \frontend\rocketChat\commands\ChainOfCommands::getCommandForInput($message->text);
        $body = $command->execute($message);

        return [
            'text' => $body
        ];
    }
}
