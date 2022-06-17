<?php

namespace MostafaHamed\DDD\Helper;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArrayFormatter{

    public static function dot($array):Array{
        $flattened = Arr::dot($array);

        $data = [];
        foreach($flattened as $folder=>$files){
            $_folder = explode('.',$folder);
            if(is_numeric(last($_folder))){
                array_pop($_folder);
                $key = implode('.',$_folder);
                if(!array_key_exists($key,$data)){
                    $data[$key] = [];
                }
                array_push($data[$key],$files);
            }else{
                $data[$folder]=$files;
            }
        }

        return $data;
    }



    public static function directories($array):Array{
        $data = Arr::dot($array);
        $new = [];

        foreach($data as $key=>$value){
            $dir=$key.'.'.$value;
            $dir = preg_replace("#\.[0-9]+\.#",DIRECTORY_SEPARATOR,$dir);
            $dir = preg_replace("#^[0-9]+\.#","",$dir);
            $new[] = str_replace('.',DIRECTORY_SEPARATOR,$dir);
        }

        return $new;
    }

    public static function files($files):Array{

        foreach($files as &$file){
            $file = pathinfo($file,PATHINFO_FILENAME);
        }
        return $files;
    }


    public static function trim(Array $array,String $string){

        array_walk($array,function(&$el) use($string){
            $el = trim($el,$string);
        });

        return $array;
    }

    public static function lower(Array $array){

        array_walk($array,function(&$el){
            $el = Str::lower($el);
        });

        return $array;
    }

    public static function camel(Array $array){

        array_walk($array,function(&$el){
            $el =  Str::ucfirst(Str::camel(Str::lower($el)));
        });

        return $array;
    }

    public static function wrap(Array $array,String $before,String $after):Array{

        array_walk($array,function(&$el) use ($before,$after){
            $el = trim($el,$before.$after);
            $el = $before.$el.$after;
        });

        return $array;
    }

}
