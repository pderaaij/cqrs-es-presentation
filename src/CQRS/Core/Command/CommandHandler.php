<?php
namespace CESPres\CQRS\Core\Command;


interface CommandHandler {
    public function isApplicableFor(Command $command);
    public function handle(Command $command);

}