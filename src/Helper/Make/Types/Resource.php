<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Resource extends Maker
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

        $className = Naming::class($values['name']. ' Resource');

        $placeholders = [
            '{{NAME}}' => $className,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $values['entity'],
        ];

        $destination = Path::toDomain($values['domain'],'Http','Resources',$values['entity']);

        if(!File::isFile($destination)){
            $single = Str::of($this->getStub('resource'))
                    ->replace(array_keys($placeholders),array_values($placeholders));
            $this->save($destination,$className,'php',$single);

            $collection = Str::of($this->getStub('resource_collection'))
                    ->replace(array_keys($placeholders),array_values($placeholders));

            $this->save($destination,$className.'Collection','php',$collection);
        }else{
            $this->command->error('File Exists');
            return false;
        }

        return true;
    }
}
