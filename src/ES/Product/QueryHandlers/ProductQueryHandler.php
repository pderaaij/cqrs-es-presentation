<?php
namespace CESPres\ES\Product\QueryHandlers;


use CESPres\ES\Core\Query\QueryCommand;
use CESPres\ES\Core\Query\QueryHandler;
use CESPres\ES\Product\Queries\ProductQuery;
use CESPres\ES\Product\Repositories\ProductViewRepository;

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