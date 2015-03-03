<?php
namespace CESPres\ES\Core\Query;


interface QueryHandler {
    public function isApplicableFor(QueryCommand $command);
    public function handle(QueryCommand $command);
}