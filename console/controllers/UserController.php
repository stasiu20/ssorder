<?php

namespace console\controllers;

use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionChangePassword($username, $password)
    {
        $user = User::findOne(['username' => $username]);
        if (null === $user) {
            $this->stderr(sprintf('User with username "%s" not exists', $username));
        }

        $user->password_hash = \Yii::$app->security->generatePasswordHash($password);
        $user->save(false, ['password_hash']);
    }

    public function actionResetPasswordLink($username)
    {
        $user = User::findOne(['username' => $username]);
        if (null === $user) {
            $this->stderr(sprintf('User with username "%s" not exists', $username));
        }

        $user->generatePasswordResetToken();
        $user->save(false, ['password_reset_token']);
        $resetLink = \Yii::$app->urlManager->createUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        $this->stdout($resetLink);
        $this->stdout(PHP_EOL);
    }
}
