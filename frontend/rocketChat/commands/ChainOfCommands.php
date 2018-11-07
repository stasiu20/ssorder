<?php

namespace frontend\rocketChat\commands;

class ChainOfCommands
{
    public static function getCommandChain()
    {
        return [
            InfoCommand::className(),
            HelpCommand::className(),
            OrderCommand::className(),
            LastOrderCommand::className(),
        ];
    }

    /**
     * @param $input
     * @return Command
     */
    public static function getCommandForInput($input)
    {
        $commands = self::getCommandChain();
        foreach ($commands as $command) {
            $isSupported = call_user_func([$command, 'supports'], $input);
            if ($isSupported) {
                return new $command();
            }
        }

        return new HelpCommand();
    }
}
