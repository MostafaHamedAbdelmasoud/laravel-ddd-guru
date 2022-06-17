<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\ArrayFormatter;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use ReflectionClass;

class TestCaseFactory
{

    public static function __callStatic($testClass, $args)
    {
        $TestCommand = $args[0];
        $domain = $args[1];

        preg_match('#^generate(.*)#', $testClass, $matches);

        $testClassNameSpace = NamespaceCreator::Segments('MostafaHamed', 'DDD', 'Helper', 'Make', 'Service', 'Test', $matches[1]);

        $testClass = new $testClassNameSpace($TestCommand, $domain);
        $testClass->generate();
    }
}
