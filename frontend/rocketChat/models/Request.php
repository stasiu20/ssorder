<?php

namespace frontend\rocketChat\models;

use yii\base\Model;

class Request extends Model
{
    public $token;
    public $bot;
    public $channel_id;
    public $channel_name;
    public $message_id;
    public $timestamp;
    public $user_id;
    public $user_name;
    public $text;

    public static function factoryFromArray(array $params)
    {
        $obj = new static();
        $obj->load($params);
        return $obj;
    }

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['token', 'bot', 'channel_id', 'channel_name', 'message_id', 'timestamp', 'user_id', 'user_name', 'text'], 'safe'],
            [['token', 'channel_id', 'message_id', 'timestamp', 'user_id', 'user_name', 'text'], 'required']
        ];
    }
}
