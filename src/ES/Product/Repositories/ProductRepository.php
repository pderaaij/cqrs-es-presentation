<?php
namespace CESPres\ES\Product\Repositories;

use CESPres\ES\Product\DomainModel\Product;

class ProductRepository extends EventRepository {

    public function find($aggregateId) {
        return $this->load($aggregateId, Product::class);
    }

}