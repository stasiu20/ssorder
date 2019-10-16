<?php

namespace frontend\rocketChat\commands;

use frontend\rocketChat\models\Request;

interface Command
{
    /**
     * @param string $text
     * @return bool
     */
    public static function supports($text): bool;

    public function execute(Request $request): string;
}
