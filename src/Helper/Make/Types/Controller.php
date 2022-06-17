<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Controller extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'controller type',
        'repository',
        'request',
        'api resource',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'controller type',
        'repository',
        'request',
        'api resource'
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [];

    public function service(Array $values):Bool{
        $name = Naming::class($values['name']);
        $domain_alias = Naming::DomainAlias($values['domain']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{NAME_REPO_VAR}}' => lcfirst($values['repository']),
            '{{NAME_REPO}}' => $values['repository'],
            '{{DOMAIN_ALIAS}}' => $domain_alias,
            '{{NAME_REQUEST}}' => $values['request'],
            '{{NAME_REQUEST_STORE}}' => $values['request'].'StoreFormRequest',
            '{{NAME_REQUEST_UPDATE}}' => $values['request'].'UpdateFormRequest',
            '{{VIEW_RESOURCE}}' => Str::of(Str::lower($values['name']))->replace(' ','_'),
            '{{RESOURCE_ROUTE_NAME}}'=>Naming::tableName($values['name']),
            '{{API_RESOURCE_NAME}}'=>Naming::class($values['api resource'])
        ];

        $className = $name.'Controller';

        if($values['controller type'] == 'SAC'){
            $destination = Path::toDomain($values['domain'],'Http','Controllers','SAC');
            $content = Str::of($this->getStub('controller-sac'))->replace(array_keys($placeholders),array_values($placeholders));
        }else{
            $destination = Path::toDomain($values['domain'],'Http','Controllers');
            $content = Str::of($this->getStub('controller'))->replace(array_keys($placeholders),array_values($placeholders));
        }

        $this->save($destination,$className,'php',$content);

        return true;
    }
}
