<?php

namespace frontend\rocketChat\models;

use yii\base\Model;

/**
* @SuppressWarnings(PHPMD.CamelCasePropertyName)
*/
class Request extends Model
{
    /** @var string */
    public $token;
    /** @var string */
    public $bot;
    /** @var string */
    public $channel_id;
    /** @var string */
    public $channel_name;
    /** @var string */
    public $message_id;
    /** @var string */
    public $timestamp;
    /** @var string */
    public $user_id;
    /** @var string */
    public $user_name;
    /** @var string */
    public $text;

    /**
     * @param array $params
     * @return Request
     */
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
