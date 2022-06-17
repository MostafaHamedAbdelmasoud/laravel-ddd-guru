<?php

namespace MostafaHamed\DDD\Helper;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

class NamespaceCreator
{
    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function Entity($domain, $entity): string
    {
        $domain = join(' ',array_filter(preg_split('#(?=[A-Z])#',$domain)));
        $entity = join(' ',array_filter(preg_split('#(?=[A-Z])#',$entity)));

        $domain = Naming::class($domain);
        $entity = Naming::class($entity);
        $class = '\\App\\Domain\\' . $domain . '\\Entities\\' . $entity;

        return $class;
    }

    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function Segments(...$segments): string
    {

        $class = '\\' . join('\\', $segments);

        return $class;
    }

    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return string
     */
    public static function table($domain, $entity): string
    {
        $class = self::Entity($domain, $entity);

        return with(new $class())->getTable();
    }


    /**
     * Create Name Space for an entity
     *
     * @param [type] $domain
     * @param [type] $entity
     * @return array
     */
    public static function fillables($domain, $entity): array
    {
        $class = self::Entity($domain, $entity);

        return with(new $class())->getFillable();
    }

    /**
     * Determine if class has methods or not
     *
     * @param [instance] $class
     */
    public static function classHasMethods($class)
    {
        $class = new ReflectionClass('UserRelations');
    }

    /**
     * Determine if class has methods or not
     *
     * @param [instance] $class
     */
    public static function classShortName(object $class)
    {
        return (new ReflectionClass($class))->getShortName();
    }
}
