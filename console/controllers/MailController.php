<?php

namespace console\controllers;

use yii\console\Controller;

class MailController extends Controller
{
    public function actionSendTestMail($email)
    {
        $result = \Yii::$app
            ->mailer
            ->compose(null)
            ->setTextBody('This is test email')
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject(sprintf('[%s] Testowy mail', \Yii::$app->name))
            ->send();
        if ($result) {
            $this->stdout('Success');
            $this->stdout(PHP_EOL);
        } else {
            $this->stderr('Error during send email');
            $this->stderr(PHP_EOL);
        }
    }
}
