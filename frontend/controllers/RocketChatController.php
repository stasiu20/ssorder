<?php

namespace frontend\controllers;

use frontend\rocketChat\filters\AuthToken;
use frontend\rocketChat\models\Request;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
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

    /**
     * @return array|Request
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request->getBodyParams();
        $message = Request::factoryFromArray($request);

        if (!$message->validate()) {
            return $message;
        }

        $command = \frontend\rocketChat\commands\ChainOfCommands::getCommandForInput($message->text);
        $body = $command->execute($message);

        //todo mmo - moze to tez zrobic na zdarzeniu? Albo na afterAction?
        /** @var Analytics $ga */
        $ga = \Yii::$container->get(\TheIconic\Tracking\GoogleAnalytics\Analytics::class);
        $ga->setEventCategory('Bot')
            ->setEventAction('call')
            ->setEventValue(get_class($command))
            ->sendEvent();

        return [
            'text' => $body
        ];
    }
}
