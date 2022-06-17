<?php

namespace MostafaHamed\DDD\Helper;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Naming
{

    /**
     * Get Domain Alias
     *
     * @param string $name
     * @return string
     */
    public static function DomainAlias($name){
        return Str::plural(Str::lower($name));
    }

    /**
     * Create Database View Name
     *
     * @param string $name
     * @return string
     */
    public static function file_name($name){
        return Str::of(Str::lower($name))->replace(' ','_');
    }

    /**
     * Create Database View Name
     *
     * @param string $name
     * @return string
     */
    public static function DatabaseViewTableName($name){
        return Str::of(Str::lower($name))->replace(' ','_');
    }

    /**
     * get Class Name
     *
     * @param string $name
     * @param string $prefix
     * @return string
     */
    public static function class($name,$prefix=''){
        return Str::ucfirst(Str::camel(Str::lower($name. ' '. $prefix)));
    }

    /**
     * get Migration file name
     *
     * @param string $action
     * @param string $table
     * @return string
     */
    public static function migration($action,$table){
        return date('Y_m_d_His').'_'.$action.'_'.$table.'_table.php';
    }


    /**
     * get DatabaseView file name
     *
     * @param string $action
     * @param string $table
     * @return string
     */
    public static function migration_database_view($action,$table){
        return date('Y_m_d_His').'_'.$action.'_'.$table.'_view.php';
    }

    /**
     * get table name
     *
     * @param string $name
     * @return string
     */
    public static function tableName($name){
        return Str::of(Str::plural(Str::lower($name)))->replace(' ','_');
    }
}
