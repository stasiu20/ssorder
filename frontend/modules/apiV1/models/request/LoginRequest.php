<?php

namespace frontend\modules\apiV1\models\request;

use common\models\User;
use yii\base\Model;

class LoginRequest extends Model
{
    /** @var string|null */
    public $userName;

    /** @var string|null */
    public $password;

    public function rules()
    {
        return [
            [['userName', 'password'], 'required'],
        ];
    }

    public function addFailedLoginError()
    {
        $this->addError('userName', \Yii::t('app', 'Niepoprawny login lub hasło.'));
    }
}
