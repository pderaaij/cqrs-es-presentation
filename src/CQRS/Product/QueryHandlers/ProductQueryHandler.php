<?php
namespace CESPres\CQRS\Product\QueryHandlers;


use CESPres\CQRS\Core\Query\QueryCommand;
use CESPres\CQRS\Core\Query\QueryHandler;
use CESPres\CQRS\Product\Queries\ProductQuery;
use CESPres\CQRS\Product\Repositories\ProductViewRepository;

class ProductQueryHandler implements QueryHandler {

    /**
     * @var ProductViewRepository
     */
    private $repository;

    public function __construct($repo) {
        $this->repository = $repo;
    }

    public function handle(QueryCommand $command) {
        return $this->repository->get($command->getProductId());
    }

    public function isApplicableFor(QueryCommand $command) {
        return ProductQuery::class === get_class($command);
    }
}