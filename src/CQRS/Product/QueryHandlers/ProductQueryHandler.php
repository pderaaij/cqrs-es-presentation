<?php
namespace CESPres\CQRS\Product\QueryHandlers;


use CESPres\CQRS\Core\Query\QueryCommand;
use CESPres\CQRS\Core\Query\QueryHandler;

class ProductQueryHandler implements QueryHandler {

    private $repository;

    public function __construct($repo) {
        $this->repository = $repo;
    }

    public function handle(QueryCommand $command) {
        return $this->repository->get($command->getProductId());
    }
}