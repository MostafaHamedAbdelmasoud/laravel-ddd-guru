<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\NamespaceCreator;

class Datatable extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity',
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
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = Naming::Class($values['name']);
        $domain = Naming::Class($values['domain']);
        $entity = Naming::Class($values['entity']);

        $file = Naming::Class($values['name']).'Datatable';

        $placeholders = [
            '{{NAME}}'              =>  $name,
            '{{DOMAIN}}'            =>  $domain,
            '{{ENTITY}}'            =>  $entity,
        ];

        $destination = Path::toDomain($values['domain'],'Datatables');

        $content = Str::of($this->getStub('datatable'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$file,'php',$content);

        $component_key = strtolower(Str::of($values['name'])->replace(' ','-'));
        $namespace = NamespaceCreator::Segments('App','Domain',$domain,'Datatables',$file);

        $this->buildComponent($component_key,$namespace,$domain);

        return true;
    }

    private function buildComponent($name,$namespace,$domain){

        $DatatableServiceProviderPath = Path::toDomain($domain,'Providers','DatatableServiceProvider.php');

        $DatatableServiceProviderContent = Str::of(File::get($DatatableServiceProviderPath))->replace(
            "###DATATABLES_PLACEHOLDER###",
            "'$name' => $namespace::class,\n\t\t\t###DATATABLES_PLACEHOLDER###"
        );

        $this->save(
            Path::toDomain($domain,'Providers'),
            'DatatableServiceProvider',
            'php',
            $DatatableServiceProviderContent
        );
    }
}
