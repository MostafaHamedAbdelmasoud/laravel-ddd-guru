<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\ArrayFormatter;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Stub;

abstract class Test
{
    protected $testCases = ['basic' => [], 'keep' => ''];

    protected abstract function generate();

    public function setUp(string $content)
    {
        return "
        public function setUp(): void
        {
            parent::setUp();
            {$content}
        }";
    }

    public function createBasicTestCases(object $testable = null)
    {
        $this->testCases['basic'] = [];
        $basicTestCases = $this->getBaseTestCases();
        $this->formateTestCases('basic', $basicTestCases, $testable);
    }

    private function getBaseTestCases()
    {
        return array_map(
            function ($testCase) {
                return $testCase->name;
            },
            (new ReflectionClass($this))
                ->getMethods(ReflectionMethod::IS_PROTECTED)
        );
    }

    private function formateTestCases(string $containerKey, array $basicTestCases, object $testable = null)
    {

        foreach ($basicTestCases as $testCase) {
            array_push(
                $this->testCases[$containerKey],
                $this->{$testCase}($testable)
            );
        }

        $this->testCases[$containerKey] = join("\n", $this->testCases[$containerKey]);
    }

    public function instantiateJustCreated(array $dir, $class, ...$args)
    {
        array_push($dir, $class);
        $model = NamespaceCreator::segments(...$dir);
        return new $model(...$args);
    }
}
