<?php

namespace frontend\rocketChat\commands;

use frontend\rocketChat\models\Request;
use yii\base\Object;

class HelpCommand extends Object implements Command
{
    public static function supports($text)
    {
        return stripos($text, 'help') === 0;
    }

    public function execute(Request $request)
    {
        $text = <<<EOS
Dostępne polecenia to:
* info - zwraca id uzytkownika i informacje o powiazaniu (lub nie) konta z ssorder
* order - informacja o dzisiejszym zamowieniu lub braku
* last - informacja o ostatnim zrealizowanym zamowieniu (ale nie w dniu dzisiejszym)
EOS;

        return $text;
    }
}
