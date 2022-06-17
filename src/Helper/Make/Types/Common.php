<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class Common extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'common_generator_type',
        'name',
        'command_http_general',
        'common_event'
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'common_generator_type',
        'command_http_general',
        'event',
        'common_event'
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
    public $requiredUnless = [
        'command_http_general' => [
            [
                'option'=>'common_generator_type',
                'value'=>'event'
            ],
            [
                'option'=>'common_generator_type',
                'value'=>'notification'
            ],
            [
                'option'=>'common_generator_type',
                'value'=>'listener'
            ],
            [
                'option'=>'common_generator_type',
                'value'=>'mail'
            ]
        ],
        'common_event'=>[
            [
                'option'=>'common_generator_type',
                'value'=>'listener'
            ],
        ]
    ];

    /**
     * Fill all placeholders in the stub file
     *
     * @return Boll
     */
    public function service(Array $values):Bool{
        return $this->{$values['common_generator_type']}($values);
    }

    /**
     * Generate Middleware
     *
     * @param Array $values
     * @return void
     */
    private function middleware($values){

        $name = Naming::class($values['name']. ' Middleware');

        $placeholders = [
            "{{NAME}}"      => $name,
        ];

        $destination = Path::toCommon('Http','Middleware');

        $content = Str::of($this->getStub('middleware'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);

        return true;
    }

    /**
     * Generate command
     *
     * @param Array $values
     * @return void
     */
    private function command($values){
        $name = Naming::class($values['name']. ' command');
        $command_name = Str::of($values['name'])->replace(' ','_');

        $placeholders = [
            "{{NAME}}"      => $name,
            "{{C_NAME}}"    => $command_name
        ];

        $destination = Path::toCommon('Commands');

        $content = Str::of($this->getStub('common_command'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);


        $console = File::get(Path::toCommon('Console','kernel.php'));
        preg_match('#namespace (.*);#',$content,$matches);
        $class = $matches[1]."\\".$name;

        $console_content =Str::of($console)->replace("###COMMON_COMMAND###","\\$class::class,\n\t\t###COMMON_COMMAND###");
        $this->save(Path::toCommon('Console'),'kernel','php',$console_content);

        return true;
    }

    /**
     * Generate scope
     *
     * @param Array $values
     * @return void
     */
    private function scope($values){
        $name = Naming::class($values['name']. ' scope');

        $placeholders = [
            '{{NAME}}' => $name,
        ];

        $dir        = Path::toCommon('Scopes');

        $content    = Str::of($this->getStub('common_scope'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($dir,$name,'php',$content);

        return true;
    }

    /**
     * Generate Event
     *
     * @param Array $values
     * @return void
     */
    private function event($values){

        $name = Naming::class($values['name']);
        $type = $values['command_http_general'];

        $placeholders = [
            '{{NAME}}' => $name,
            '{{TYPE}}'=>$type
        ];

        $className = $name.'Event';

        $destination = Path::toCommon('Events',$type);

        $content = Str::of($this->getStub('common_event'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$className,'php',$content);

        return true;
    }

    /**
     * Generate Notification
     *
     * @param Array $values
     * @return void
     */
    private function notification($values){

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{TYPE}}' => $values['command_http_general'],
        ];

        $className = $name.'Notification';

        $destination = Path::toCommon('Notifications',$values['command_http_general']);

        $content = Str::of($this->getStub('common_notification'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$className,'php',$content);

        return true;
    }


    /**
     * Generate Listener
     *
     * @param Array $values
     * @return void
     */
    private function listener($values){

        $name = Naming::class($values['name']);

        $type = $values['command_http_general'];

        $placeholders = [
            '{{NAME}}' => $name,
            '{{EVENT_NAME}}' => $values['common_event'],
            '{{TYPE}}' => $type
        ];

        $className = $name.'Listener';

        $destination = Path::toCommon('Listeners',$type);

        $content = Str::of($this->getStub('common_listener'))
                        ->replace(array_keys($placeholders),array_values($placeholders));


        $this->save($destination ,$className ,'php', $content);

        return true;
    }

    /**
     * Generate Notification
     *
     * @param Array $values
     * @return void
     */
    private function mail($values){

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{TYPE}}' => $values['command_http_general'],
        ];

        $destination = Path::toCommon('Mails',$values['command_http_general']);

        $content = Str::of($this->getStub('common_mail'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$name,'php',$content);

        return true;
    }
}
