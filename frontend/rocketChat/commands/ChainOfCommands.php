<?php

namespace frontend\rocketChat\commands;

class ChainOfCommands
{
    public static function getCommandChain(): array
    {
        return [
            InfoCommand::class,
            HelpCommand::class,
            OrderCommand::class,
            LastOrderCommand::class,
            HistoryCommand::class,
            ReorderCommand::class,
        ];
    }

    public static function getCommandForInput(string $input): Command
    {
        $commands = self::getCommandChain();
        foreach ($commands as $command) {
            $isSupported = $command::supports($input);
            if ($isSupported) {
                return new $command();
            }
        }

        return new HelpCommand();
    }
}
