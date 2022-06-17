<?php

namespace MostafaHamed\DDD\Helper\Make\Service;

use MostafaHamed\DDD\Helper\Make\Maker;

/**
 * Abstract class to manage the creation of Common components such as : Domain,Controller ect.
 */
class NullMaker extends Maker{
    /**
     * Holds an instance of the current command
     *
     * @var Illuminate\Console\Command
     */
    public $command;

    /**
     * Construct
     *
     * @param Illuminate\Console\Command $ci Command Instance
     */
    public function __construct($ci){
        $this->command = $ci;
    }

    /**
     * Process the creation of files related to the current Command
     *
     * @param Array $values
     * @return Bool
     */
    public function service(Array $values):Bool{
        return false;
    }
}
