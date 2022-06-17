<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Factory extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity'
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity'
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
     * @return Bool
     */
    public function service(Array $values = []):bool{
        $domain = Naming::class($values['domain']);
        $entity = Naming::class($values['name']);
        $file = Naming::class($values['name'],'factory');

        $attributes ="\n";

        $placeholders = [
            '{{DOMAIN}}' => $domain,
            '{{ENTITY}}' => $entity,
            '{{KEYS_PLACEHOLDER}}' => $attributes
        ];

        $destination = Path::toDomain($domain,'Database','Factories');

        $content = Str::of($this->getStub('factory'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination, $file, 'php', $content);

        return true;
    }

}
