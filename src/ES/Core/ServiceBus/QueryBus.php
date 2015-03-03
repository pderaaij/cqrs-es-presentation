<?php
namespace CESPres\ES\Core\ServiceBus;


use CESPres\Core\Exceptions\QueryHandlerNotFoundException;
use CESPres\ES\Core\Query\QueryCommand;
use CESPres\ES\Core\Query\QueryHandler;

class QueryBus {

    /**
     * @var QueryHandler[]
     */
    private $handlers = array();

    public function handle(QueryCommand $command) {
        foreach($this->handlers as $handler) {
            if ($handler->isApplicableFor($command)) {
                return $handler->handle($command);
            }
        }

        throw new QueryHandlerNotFoundException("No handler defined for query " . get_class($command));
    }

    public function registerHandler(QueryHandler $queryHandler) {
        $this->handlers[] = $queryHandler;
    }
}