<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Command extends Maker
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
        'domain'
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


    public function service(Array $values):Bool{

        $name = Naming::class($values['name']. ' command');

        $command_name = Str::of($values['name'])->replace(' ','_');

        $placeholders = [
            "{{NAME}}"      => $name,
            "{{C_NAME}}"    => $command_name,
            "{{DOMAIN}}"=> $values['domain'],
        ];

        $destination = Path::toDomain($values['domain'],'Commands');

        $content = Str::of($this->getStub('command'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);

        $console = File::get(Path::toCommon('Console','kernel.php'));

        preg_match('#namespace (.*);#',$content,$matches);
        $class = $matches[1]."\\".$name;

        $console_content =Str::of($console)->replace("###COMMON_COMMAND###","\\$class::class,\n\t\t###COMMON_COMMAND###");
        $this->save(Path::toCommon('Console'),'kernel','php',$console_content);

        return true;
    }

}
