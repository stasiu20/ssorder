<?php

namespace common\component;

use RocketChatPhp\Client;
use yii\base\Component;

class RocketChat extends Component
{
    /** @var string */
    public $endpoint;

    /** @var string */
    public $token;

    /** @var Client */
    private $client;

    public function init()
    {
        $this->client = new Client($this->endpoint, $this->token);
    }

    /**
     * @param string $text
     */
    public function sendText($text)
    {
        $this->client->payload([
            'text' => $text
        ]);
    }
}
