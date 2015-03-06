<?php
namespace CESPres\ES\Core\Command;

/**
 * Interface CommandHandler
 *
 * @package CESPres\ES\Core\Command
 */
interface CommandHandler {
    public function isApplicableFor(Command $command);
    public function handle(Command $command);

}