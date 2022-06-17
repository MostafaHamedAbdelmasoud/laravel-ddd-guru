<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Mail extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'command_http_general',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'command_http_general'
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

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{TYPE}}' => $values['command_http_general'],
            '{{DOMAIN_ALIAS}}' => Naming::DomainAlias($values['domain']),

        ];

        $destination = Path::toDomain($values['domain'],'Mail',$values['command_http_general']);

        $content = Str::of($this->getStub('mail'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);

        return true;
    }

}
