<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Stub;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Seeder extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity',
        'count',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity',
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
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name   = Naming::class($values['name']);
        $domain = Naming::class($values['domain']);
        $entity = Naming::class($values['entity']);
        $file   = Naming::class($values['name'],'table seeder');

        $placeholders = [
            '{{NAME}}'      => $name,
            '{{DOMAIN}}'    => $domain,
            '{{ENTITY}}'    => $entity,
            '{{COUNT}}'     => $values['count'],
        ];

        $destination = Path::toDomain($values['domain'],'Database','Seeds');

        $content = Str::of($this->getStub('seeder'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$file,'php',$content);

        return true;
    }

}
