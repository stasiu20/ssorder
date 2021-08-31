<?php

namespace App\Webpush\Exception;

use InvalidArgumentException;

class UnexpectedTypeException extends InvalidArgumentException
{
    /**
     * @param mixed  $value
     * @param string $expectedType
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type %s, %s given', $expectedType, get_debug_type($value)));
    }
}
