<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Policy extends Maker
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
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $values['entity'],
            '{{ENTITY_LC}}' => Str::lower($values['entity']),
        ];

        $dir = Path::toDomain($values['domain'],'Policies');

        if(!File::isDirectory($dir)){
            File::makeDirectory($dir);
        }

        $content = Str::of($this->getStub('policy'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($dir,$name,'php',$content);


        $ServiceProviderPath = Path::toDomain($values['domain'],'Providers');

        $content = File::get(Path::build($ServiceProviderPath,'PolicyServiceProvider.php'));

        $entity_namespace = NamespaceCreator::Segments('App','Domain',$values['domain'],'Entities',$values['entity']);
        $policy_namespace = NamespaceCreator::Segments('App','Domain',$values['domain'],'Policies',$name);

        $policyServiceProviderContent = Str::of($content)->replace(
            "###POLICIES###",
            "$entity_namespace::class => $policy_namespace::class,\n\t\t###POLICIES###"
        );

        $this->save($ServiceProviderPath,'PolicyServiceProvider','php',$policyServiceProviderContent);
        return true;
    }

}
