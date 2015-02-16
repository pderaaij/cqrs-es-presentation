<?php
namespace CESPres\Utilities;

use Composer\Script\Event;

/**
 * Description of DatabaseInitialization
 *
 * @author pderaaij
 */
class DatabaseInitialization
{
    public static function init(Event $event) {
        $db = new \SQLite3('cqrs-es-db.sqlite');
        $db->exec('CREATE TABLE products (productId INTEGER PRIMARY KEY, name VARCHAR(255), description TEXT, salesPrice DECIMAL(5,2));');
    }
}
