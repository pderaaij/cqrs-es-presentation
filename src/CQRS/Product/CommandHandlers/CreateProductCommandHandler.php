<?php
namespace CESPres\CQRS\Product\CommandHandlers;


use CESPres\CQRS\Core\Command\Command;
use CESPres\CQRS\Core\Command\CommandHandler;
use CESPres\CQRS\Product\Commands\CreateProductCommand;
use CESPres\CQRS\Product\DomainModel\Product;
use CESPres\CQRS\Product\Repositories\ProductRepository;

final class CreateProductCommandHandler implements CommandHandler {

    /**
     * @var ProductRepository
     */
    private $productRepository;

    function __construct($productRepository) {
        $this->productRepository = $productRepository;
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
    }

}