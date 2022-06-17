<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Repo extends Maker
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
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = $values['name'];

        $placeholders = [
            '{{DOMAIN}}' => $values['domain'],
            '{{NAME}}' => Naming::class($name),
            '{{ENTITY}}' => Naming::class($values['entity']),
        ];

        // Create Contract
        $contract_className = Naming::class($name).'Repository';

        $destination = Path::toDomain($values['domain'],'Repositories','Contracts');

        $content = Str::of($this->getStub('contract'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$contract_className,'php',$content);

        // Create Eloquent
        $eloquent_className = Naming::class($name).'Repository'.'Eloquent';

        $destination = Path::toDomain($values['domain'],'Repositories','Eloquent');

        $content = Str::of($this->getStub('eloquent'))
                        ->replace(array_keys($placeholders),array_values($placeholders));
        $this->save($destination,$eloquent_className,'php',$content);


        $contract = NamespaceCreator::Segments('App','Domain',$values['domain'],'Repositories','Contracts',$contract_className);
        $eloquent = NamespaceCreator::Segments('App','Domain',$values['domain'],'Repositories','Eloquent',$eloquent_className);

        $RepositoryServiceProviderPath = Path::toDomain($values['domain'],'Providers','RepositoryServiceProvider.php');

        $RepositoryServiceProviderContent = Str::of(File::get($RepositoryServiceProviderPath))->replace(
            "###REPOSITORIES_PLACEHOLDER###",
            "$contract::class => $eloquent::class,\n\t\t\t###REPOSITORIES_PLACEHOLDER###"
        );
        $this->save(
            Path::toDomain($values['domain'],'Providers'),
            'RepositoryServiceProvider',
            'php',
            $RepositoryServiceProviderContent
        );
        return true;
    }
}
