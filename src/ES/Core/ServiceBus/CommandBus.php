<?php
namespace CESPres\ES\Core\ServiceBus;


use CESPres\Core\Exceptions\CommandHandlerNotFoundException;
use CESPres\ES\Core\Command\Command;
use CESPres\ES\Core\Command\CommandHandler;

class CommandBus {

    /**
     * @var CommandHandler[]
     */
    private $commandHandlers = array();

    /**
     * @param Command $command
     * @return mixed
     * @throws CommandHandlerNotFoundException
     */
    public function handle(Command $command) {
        foreach($this->commandHandlers as $handler) {
            if ($handler->isApplicableFor($command)) {
                return $handler->handle($command);
            }
        }

        throw new CommandHandlerNotFoundException("No handler defined for query " . get_class($command));
    }

    /**
     * @param CommandHandler $handler
     */
    public function registerHandler(CommandHandler $handler) {
        $this->commandHandlers[] = $handler;
    }
}