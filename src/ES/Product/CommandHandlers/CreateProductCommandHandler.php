<?php
namespace CESPres\ES\Product\CommandHandlers;

use CESPres\ES\Core\Command\Command;
use CESPres\ES\Core\Command\CommandHandler;
use CESPres\ES\Product\Commands\CreateProductCommand;
use CESPres\ES\Product\DomainModel\Product;
use CESPres\ES\Product\Repositories\EventRepository;
use CESPres\ES\Product\Repositories\ProductRepository;
use CESPres\ES\Product\Repositories\ProductViewRepository;
use Symfony\Component\EventDispatcher\Event;

/**
 * Simple command demonstrating immediate consistency
 * 
 */
final class CreateProductCommandHandler implements CommandHandler {

    /**
     * @var EventRepository
     */
    private $eventRepository;

    function __construct(EventRepository $productRepository) {
        $this->eventRepository = $productRepository;
    }

    /**
     * @param Command $command
     * @return bool
     */
    public function isApplicableFor(Command $command) {
        return $command instanceof CreateProductCommand;
    }

    /**
     * @param Command|CreateProductCommand $command
     */
    public function handle(Command $command) {
        $product = Product::create($command->getProductId(), $command->getInternalName(), false);

        $this->eventRepository->add($product);
    }

}