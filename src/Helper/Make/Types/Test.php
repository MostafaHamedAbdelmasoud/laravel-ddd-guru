<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Make\Service\Test\TestCaseFactory;

class Test extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'domain'
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain'
    ];

    public function service(array $values): bool
    {
        $segments = ['app', 'Domain', $values['domain'], 'Entities'];
        TestCaseFactory::generateEntities($this, $values['domain']);
        TestCaseFactory::generateEntitiesRelations($this, $values['domain']);
        TestCaseFactory::generateRepositoriesEloquent($this, $values['domain']);
        TestCaseFactory::generateResources($this, $values['domain']);
        // TestCaseFactory::generateFormRequest($this, $values['domain']);
        return 1;
    }


    /**
     * Create Test cases for endpoints
     *
     * @return void
     */
    private function endpoints()
    {
    }

    /**
     * Create Test cases for relations
     *
     * @return void
     */
    private function relations()
    {
    }

    /**
     * Create Test cases for entities
     *
     * @return void
     */
    private function entities()
    {
    }

    /**
     * Create Test cases for requests
     *
     * @return void
     */
    private function requests()
    {
    }

    /**
     * Create Test cases for api_resources
     *
     * @return void
     */
    private function api_resources()
    {
    }

    /**
     * Create Test cases for repositories
     *
     * @return void
     */
    private function repositories()
    {
    }
}
