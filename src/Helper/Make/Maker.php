<?php

namespace MostafaHamed\DDD\Helper\Make;

use MostafaHamed\DDD\Helper\ArrayFormatter;
use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Stub;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Abstract class to manage the creation of Common components such as : Domain,Controller ect.
 */
abstract class Maker{

    use Stub;

    /**
     * Holds an instance of the current command
     *
     * @var Illuminate\Console\Command
     */
    public $command;

    /**
     * Holds an instance of the current command
     *
     * @var Illuminate\Console\Command
     */
    public $values;

    /**
     * Return options to be included inside the command line
     *
     * @return Array
     */
    public $options = [];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [];

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
     * Determine if the current generator creates only one file or groups
     *
     * @var array
     */
    public $files= [];

    /**
     * Construct
     *
     * @param Illuminate\Console\Command $ci Command Instance
     */
    public function __construct($ci = ''){
        $this->command = $ci;
    }


    /**
     * Retrive the options for the class
     *
     * @return Array
     */
    public static function getOptions():Array{
        return with(new static)->options;
    }

    /**
     * Retrive the options for the class
     *
     * @return Array
     */
    public static function getSignature():Array{
        $in = new static;
        $options = $in->options;
        $boolean = $in->booleanOptions;
        array_walk($options,function(&$el) use($boolean){
            if(!in_array($el,$boolean)){
                $el.='=';
            }
        });
        return $options;
    }
    /**
     * key option value by key
     *
     * @param string $key
     * @return string
     */
    public function getValues():array{

        $this->options = $this->fillInsertedOptions();

        foreach($this->options as $option => &$value){

            if($value!=null) continue;

            // $option = trim($option,'=');
            // Check if the current options is based on other option
            if(array_key_exists($option,$this->requiredUnless)){

                if(is_array($this->requiredUnless[$option])){
                    foreach($this->requiredUnless[$option] as $_option){
                        $related_option = $_option;

                        $fulfilled = $this->options[$related_option['option']] == $related_option['value'];

                        if($fulfilled){
                            $value = $this->getOptionValue($option);
                            break;
                        }else{
                            continue;
                        }
                    }
                }else{
                    $related_option = $this->requiredUnless[$option];

                    $fulfilled = $this->options[$related_option['option']] == $related_option['value'];

                    if($fulfilled){
                        $value = $this->getOptionValue($option);
                    }else{
                        continue;
                    }

                }

            }else{
                $value = $this->getOptionValue($option);
            }
        }

        return $this->options;
    }

    /**
     * Get options value
     *
     * @param [type] $option
     * @return void
     */
    private function getOptionValue($option){

        if(in_array($option,$this->allowChoices)){
            $value = $this->choices($option);
        }elseif(in_array($option,$this->booleanOptions)){
            $value = $this->command->choice('Is '.$option.' ?',['no','yes'],0) == 'yes' ? true : false;
        }else{
            $value = $this->command->ask($option);
        }
        return $value;
    }
    private function choices($key):String{
        $key= Str::lower(trim($key,'_='));

        $answer = '';

        switch ($key) {
            case 'common_generator_type':
                $common_types = ['middleware', 'command', 'scope', 'event', 'notification', 'listener', 'mail'];
                [$key, $array, $error] = ["Common Type", $common_types, "No Common Types Available, Please create one"];
                break;
            break;

            case 'domain':
                $domains = Path::getDomains();

                [$key, $array, $error] = ["Domain", $domains, "No Domains Available, Please create one"];

                break;
            case 'entity':
                $entities = Path::files('app','Domain',$this->options['domain'],'Entities');

                [$key, $array, $error] = ["Entity", $entities, "No Entities Available inside ".$this->options['domain']];

                break;

            case 'command_http_general':
                $command_http_general = ['Command','Http','General'];

                [$key, $array, $error] = ["Type", $command_http_general, "No Types Available"];

                break;

            case 'database view':

                $database_views = Path::files('app','Domain',$this->options['domain'],'Entities','Views');

                [$key, $array, $error] = ["Database View", $database_views, "No DatabaseViews Available inside ".$this->options['domain']];

                break;
            case 'resource name':

                $resources_views = Path::directories('app','Domain',$this->options['domain'],'Resources','Views');

                [$key, $array, $error] = ["Resource Name", $resources_views, "No HTML Resources Available inside ".$this->options['domain']];

                break;
            case 'event':

                $events = Path::files('app','Domain',$this->options['domain'],'Events',$this->options['command_http_general']);

                [$key, $array, $error] = ["Event", $events, "No Events Available inside ".$this->options['domain']];

                break;
            case 'common_event':

                $events = Path::files('app','common','Events',$this->options['command_http_general']);

                [$key, $array, $error] = ["Event", $events, "No Events Available inside Common"];

                break;
            case 'controller type':

                $controllers = [ 'Resource', "SAC"];

                [$key, $array, $error] = ["Type", $controllers, "No Controller Types Available inside ".$this->options['domain']];

                break;
            case 'api version':

                $versions = Path::directories('app','Domain',$this->options['domain'],'Http','Controllers','Api');

                [$key, $array, $error] = ["API Version", $versions, "No API Versions Available inside ".$this->options['domain']];

                break;
            case 'api type':

                $types = [ 'Resource', 'SAC'];

                [$key, $array, $error] = ["API Type", $types, "No API Types Available inside ".$this->options['domain']];

                break;
            case 'repository':
                $interfaces = Path::files('app','Domain',$this->options['domain'],'Repositories','Contracts');

                [$key, $array, $error] = ["Repository", $interfaces, "No Repositories Available inside ".$this->options['domain']];

                break;
            case 'datatable':
                $datatables = Path::files('app','Domain',$this->options['domain'],'DataTables');

                [$key, $array, $error] = ["DataTables", $datatables, "No Datatables Available inside ".$this->options['domain']];

                break;
            case 'request':
                $requests = Path::directories('app','Domain',$this->options['domain'],'Http','Requests');

                [$key, $array, $error] = ["requests", $requests, "No Request Class Available inside ".$this->options['domain']];

                break;
            case 'api resource':
                $requests = Path::directories('app','Domain',$this->options['domain'],'Http','Resources');

                [$key, $array, $error] = ["API Resource", $requests, "No API Resources Available inside ".$this->options['domain']];

                break;
            case 'backups':
                $backups = Path::directories('backup');

                [$key, $array, $error] = ["Backup Date", $backups, "No Backups Available"];

                break;
            case 'test type':
                $types = [ 'All', 'Feature', 'Unit'];

                [$key, $array, $error] = ["Test Type", $types, "Test Type Not Valid"];

                break;

            case 'graphql type':
                $types = [ '.graphql', '.php'];

                [$key, $array, $error] = ["Graphql Type", $types, "Graphql Type Not Valid"];

                break;
            case 'graphql php type':
                $types = [
                    'query',
                    'mutation',
                    'directive',
                    'scalar'
                ];

                [$key, $array, $error] = ["Graphql PHP Type", $types, "Graphql PHP Type Not Valid"];

                break;
        }

        $this->validChoice($array,$error);

        $answer = $this->command->choice($key,$array,0);

        return $answer;
    }

    /**
     * Fill options with values inserted via terminal
     *
     * @return Array
     */
    private function fillInsertedOptions():Array{
        $options = array_fill_keys($this->getOptions(),null);

        foreach($options as $key=>&$value){
            if(array_key_exists($key,$this->command->options()) && $this->command->option($key)!=null){
                $value = $this->command->option($key);
            }
        }

        return $options;
    }


    private function validChoice($array,$message){
        if(!is_array($array) || count($array)==0){
            $this->command->error($message);

            exit();
        }
    }

    /**
     * Fetch Data
     *
     * @return void
     */
    public function create(){

        $this->values = $this->getValues();

        return static::service($this->values);
    }

    /**
     * Process the creation of files related to the current Command
     *
     * @param Array $values
     * @return Bool
     */
    abstract public function service(Array $values):Bool;


    public static function createService($values){
        $in = new static();

        $in->service($values);
    }

    public function save($destination,$name,$ext,$content):void{
        if(!File::isDirectory($destination)){
            File::makeDirectory($destination,0755,true,true);
        }
        $file = Path::build($destination,"$name.$ext");

        File::put($file,$content);
    }
}
