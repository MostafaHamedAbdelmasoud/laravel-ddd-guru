<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Request extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [];
    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $className = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $className,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $className,
            '{{ENTITY_LC}}' => Str::lower($className),
            '{{ENTITY_PL}}' => Str::plural(Str::lower($className)),
        ];

        $destinationStore = Path::toDomain($values['domain'],'Http','Requests',$className);

        $contentStore = Str::of($this->getStub('request-store'))
        ->replace(array_keys($placeholders),array_values($placeholders));
        $this->save($destinationStore,$className.'StoreFormRequest','php',$contentStore);



        $destinationUpdate = Path::toDomain($values['domain'],'Http','Requests',$className);
        $contentUpdate = Str::of($this->getStub('request-update'))
                ->replace(array_keys($placeholders),array_values($placeholders));
        $this->save($destinationUpdate,$className.'UpdateFormRequest','php',$contentUpdate);

        return true;
    }
}
