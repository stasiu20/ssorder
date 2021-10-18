<?php

namespace common\component;

class NullRocketChat extends RocketChat
{
    public function init(): void
    {
    }

    /**
     * @param string $text
     */
    public function sendText($text): void
    {
    }
}
