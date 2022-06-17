<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Event extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'command_http_general'
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
        $type = $values['command_http_general'];

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{TYPE}}'=>$type
        ];

        $className = $name.'Event';

        $destination = Path::toDomain($values['domain'],'Events',$type);

        $content = Str::of($this->getStub('event'))
                        ->replace(array_keys($placeholders),array_values($placeholders));
        $this->save($destination,$className,'php',$content);

        preg_match('#namespace (.*);#',$content,$matches);

        $class = $matches[1]."\\".$className;


        $eventServiceProviderPath = Path::toDomain($values['domain'],'Providers');

        $content = File::get(Path::build($eventServiceProviderPath,'EventServiceProvider.php'));

        $eventServiceProviderContent = Str::of($content)->replace(
            "###EVENTS###",
            "\\$class::class => [\n\t\t\t###LISTENERS_{$type}_$className###\n\t\t],\n\t\t###EVENTS###"
        );

        $this->save($eventServiceProviderPath,'EventServiceProvider','php',$eventServiceProviderContent);

        return true;
    }

}
