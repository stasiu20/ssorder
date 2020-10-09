<?php

namespace common\enums;

use MyCLabs\Enum\Enum;

/**
 * @method static OrderSource WEB()
 * @method static OrderSource BOT()
 * @method static OrderSource API()
 */
class OrderSource extends Enum
{
    public const WEB = 'web';
    public const BOT = 'bot';
    public const API = 'api';
}
