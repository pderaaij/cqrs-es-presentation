<?php
namespace CESPres\CQRS\Product\Commands;


use CESPres\CQRS\Core\Command\Command;

class CreateProductCommand implements Command {

    private $internalName;

    function __construct($internalName)
    {
        $this->internalName = $internalName;
    }

    /**
     * @return mixed
     */
    public function getInternalName()
    {
        return $this->internalName;
    }

}