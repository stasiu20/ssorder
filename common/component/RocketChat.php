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
    private $_client;

    public function init(): void
    {
        $this->_client = new Client($this->endpoint, $this->token);
    }

    /**
     * @param string $text
     */
    public function sendText($text): void
    {
        $this->_client->payload([
            'text' => $text
        ]);
    }
}
