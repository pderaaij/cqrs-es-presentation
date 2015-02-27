<?php
namespace CESPres\Core\Services\Database;


class ReadManager extends Manager {

    function __construct() {
        parent::__construct(new \SQLite3(SQLITE_READ_DB_PATH));
    }
}