<?php
namespace CESPres\Core\Services\Database;


class FullAccessManager extends Manager {

    function __construct() {
        parent::__construct(new \SQLite3(SQLITE_DB_PATH));
    }

}