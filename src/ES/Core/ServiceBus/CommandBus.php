<?php
/**
 * Created by PhpStorm.
 * User: pderaaij
 * Date: 27-2-15
 * Time: 9:08
 */

namespace CESPres\ES\Core\ServiceBus;


use CESPres\Core\Exceptions\CommandHandlerNotFoundException;
use CESPres\ES\Core\Command\Command;
use CESPres\ES\Core\Command\CommandHandler;

class CommandBus {

    /**
     * @var CommandHandler[]
     */
    private $commandHandlers = array();

    public function handle(Command $command) {
        foreach($this->commandHandlers as $handler) {
            if ($handler->isApplicableFor($command)) {
                return $handler->handle($command);
            }
        }

        throw new CommandHandlerNotFoundException("No handler defined for query " . get_class($command));
    }

    public function registerHandler(CommandHandler $handler) {
        $this->commandHandlers[] = $handler;
    }
}