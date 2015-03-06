<?php
namespace CESPres\ES\Product\Repositories;


use CESPres\ES\Product\DomainModel\Product;

class ProductRepository {

    public function find($uuid) {
        $repo = new EventRepository();
        $events = $repo->findForAggregateId($uuid);

        $product = new Product();
        $product->rehydrate($events);

        return $product;
    }
}