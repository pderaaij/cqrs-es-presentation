<?php
namespace CESPres\CQRS\Product\CommandHandlers;


use CESPres\CQRS\Core\Command\Command;
use CESPres\CQRS\Core\Command\CommandHandler;
use CESPres\CQRS\Product\Commands\CreateProductCommand;
use CESPres\CQRS\Product\DomainModel\Product;
use CESPres\CQRS\Product\Repositories\ProductRepository;
use CESPres\CQRS\Product\Repositories\ProductViewRepository;

final class CreateProductCommandHandler implements CommandHandler {

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductViewRepository
     */
    private $productViewRepository;

    function __construct(ProductRepository $productRepository, ProductViewRepository $viewRepository) {
        $this->productRepository = $productRepository;
        $this->productViewRepository = $viewRepository;
    }

    public function isApplicableFor(Command $command) {
        return $command instanceof CreateProductCommand;
    }

    /**
     * @param Command|CreateProductCommand $command
     */
    public function handle(Command $command) {
        // @TODO: should create a product GUID
        $product = new Product();
        $product->setInternalName($command->getInternalName());
        $product->setActive(false);

        $this->productRepository->add($product);
        $this->productViewRepository->sync($product);
    }

}