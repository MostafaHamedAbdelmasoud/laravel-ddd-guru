<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\NamespaceCreator;

class DatabaseView extends Maker
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

        $name = Naming::class($values['name']);
        $file = Naming::class($values['name'],'view');

        $placeholders = [
            "{{NAME}}"      => $name,
            "{{DOMAIN}}"    => $values['domain'],
            "{{TABLE}}"     => Naming::DatabaseViewTableName($name),
        ];

        $destination = Path::toDomain($values['domain'],'Entities','Views');

        $content = Str::of($this->getStub('database-view'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$file,'php',$content);

        $this->createMigrationFile($values);
        return true;
    }

    public function createMigrationFile($values){

        $domain = $values['domain'];
        $name = $values['name'];
        $table = Naming::DatabaseViewTableName($name);
        $placeholders = [
            '{{NAME}}'              =>   $name,
            '{{TABLE}}'             =>   $table,
        ];
        $fileName = Naming::migration_database_view('create', $table);

        $destination = Path::toDomain($domain,'Database','Migrations');

        $content = Str::of($this->getStub('migration_view'))
        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,trim($fileName,'.php'),'php',$content);

        return true;
    }
}
