<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GraphqlTest extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity related',
        'entity',
        'test type',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity',
        'test type'
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [
        'entity related',
    ];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [
        'entity'=>[
            'option'    =>  'entity related',
            'value'     =>  true
        ],
    ];


    public function service(Array $values):Bool{

        $name = Naming::class($values['name']);

        $placeholders = [
            "{{DOMAIN}}"=>$values['domain'],
            "{{NAME}}"=>$name,
            "{{ENTITY}}"=>$values['entity'],
            "{{ENTITY_LC}}"=>Str::lower($values['entity']),
            "{{ENTITY_PLURAL}}"=>Str::plural(Str::lower($values['entity']))
        ];

        $prefix= $values['entity related'] ? "magic-" : "";

        $types = $values['test type'] == 'All' ? ['Feature','Unit'] : [$values['test type']];

        foreach ($types as $type) {
            $content = Str::of($this->getStub($prefix.$type))->replace(array_keys($placeholders),array_values($placeholders));
            File::put(Path::toDomain($values['domain'],'Tests',$type,$name.'Test.php'),$content);
        }

        return true;
    }

}
