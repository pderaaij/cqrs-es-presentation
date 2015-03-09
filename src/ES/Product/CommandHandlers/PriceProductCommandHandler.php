<?php
namespace CESPres\ES\Product\CommandHandlers;

use CESPres\ES\Core\Command\Command;
use CESPres\ES\Core\Command\CommandHandler;
use CESPres\ES\Product\Commands\PriceProductCommand;
use CESPres\ES\Product\Commands\PublishProductCommand;
use CESPres\ES\Product\DomainModel\Product;
use CESPres\ES\Product\Repositories\EventRepository;
use CESPres\ES\Product\Repositories\ProductViewRepository;

/**
 * Handle product publish command.
 * 
 */
final class PriceProductCommandHandler implements CommandHandler {

    /**
     * @var EventRepository
     */
    private $eventRepository;

    function __construct(EventRepository $eventRepository) {
        $this->eventRepository = $eventRepository;
    }

    public function isApplicableFor(Command $command) {
        return $command instanceof PriceProductCommand;
    }

    /**
     * @param Command|PublishProductCommand $command
     */
    public function handle(Command $command) {
        $product = $this->eventRepository->load($command->getProductId(), Product::class);
        $product->pricing($command->getExclVat(), $command->getInclVat());

        $this->eventRepository->add($product);
    }

}