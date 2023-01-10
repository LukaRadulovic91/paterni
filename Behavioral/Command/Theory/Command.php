<?php

namespace paterni\Behavioral\Command\Theory;

/**
 * The Command interface declares a method for executing a command.
 */
interface Command
{
    public function execute(): void;
}