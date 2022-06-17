<?php

namespace MostafaHamed\DDD\Helper\Make\Types;

use MostafaHamed\DDD\Helper\FileCreator;
use MostafaHamed\DDD\Helper\Make\Maker;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Path;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Sync extends Maker
{
    /**
     * Options to be available once Command-Type is called
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
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $sync = [];

    /**
     * Fill all placeholders in the stub file
     *
     * @return Boll
     */
    public function service(Array $values):Bool{
        $this->command->info('Not implemented');
        return true;
        if(!File::exists(base_path('columns-match').'.json')){
            $template_name = [
                [
                    "table"=>"migration_table_name",
                    "sync"=>[
                        [
                            "type"=>"Entity | API Resource | Request",
                            "domain"=>"Post",
                            "name"=>"Post"
                        ]
                    ]
                ]
            ];
            File::put(base_path('columns-match').'.json',json_encode($template_name,JSON_PRETTY_PRINT));
            $this->command->error('Please fill columns-match.json file');
            return false;
        }

        $sync =json_decode(File::get(base_path('columns-match').'.json'),true);

        $tables = join("','",collect($sync)->map(function($el){
            return $el['table'];
        })->toArray());

        $columns =  DB::select(DB::raw("SELECT *
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME in('$tables') AND TABLE_SCHEMA = '".env('DB_DATABASE')."'"));

        $_columns=[];
        foreach($columns as $column){
            $_columns[$column->TABLE_NAME][]=$column->COLUMN_NAME;
        }

        foreach($sync as $t){

            foreach($t['sync'] as $type){

                $this->{$type['type']}($type['domain'],$type['name'],$_columns[$t['table']]);

            }
        }

        return true;
    }

    private function entity($domain,$name,$columns){
        $file= File::get(Path::toDomain($domain,'Entities',"$name.php"));


        dd($file,$columns);
    }

}
