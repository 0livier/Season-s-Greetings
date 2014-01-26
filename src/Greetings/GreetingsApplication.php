<?php

namespace Greetings;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Greetings\Command\GreetingsCommand;

class GreetingsApplication extends Application
{
    protected function getCommandName(InputInterface $input)
    {
        return 'greetings';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new GreetingsCommand();

        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
