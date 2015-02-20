<?php
namespace CESPres\CQRS\Core\ServiceBus;


use CESPres\CQRS\Core\Query\QueryCommand;
use CESPres\CQRS\Core\Query\QueryHandler;

class QueryBus {

    /**
     * @var QueryHandler[]
     */
    private $handlers = array();

    public function handle(QueryCommand $command) {
        foreach($this->handlers as $handler) {
            return $handler->handle($command);
        }
    }

    public function registerHandler(QueryHandler $queryHandler) {
        $this->handlers[] = $queryHandler;
    }
}