<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use ReflectionClass;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Path;
use MostafaHamed\DDD\Helper\Naming;
use MostafaHamed\DDD\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use MostafaHamed\DDD\Helper\NamespaceCreator;
use MostafaHamed\DDD\Helper\Make\Service\Test\Test;

class Entities extends Test
{
    private $domain;
    private $entitiesDirPath;
    private $entities;
    private $entityShortName;
    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->entitiesDirPath = ['App', 'Domain', $domain, 'Entities'];
        $this->entities = Path::files(...$this->entitiesDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->entities as $entity) {
            $name = $entity;
            $entityInstance = $this->instantiateJustCreated($this->entitiesDirPath, $entity);
            $this->entityShortName = NamespaceCreator::classShortName($entityInstance);
            $this->entityReflection = new ReflectionClass($entityInstance);
            $this->createBasicTestCases($entityInstance);

            $placeholders = [
                '{{NAME}}' => $name,
                '{{DOMAIN}}' => $this->domain,
                '{{TESTCASES}}' => $this->testCases['basic'],
                '{{JWTMETHODS}}' => $this->createJWTMethods(),
                '{{SETUP}}' => $this->createSetupMethod($entity)
            ];

            $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Entities');

            $content = Str::of($this->TestCommand->getStub('entity-test'))
                ->replace(array_keys($placeholders), array_values($placeholders));

            $classFullName = $name . 'Test';

            $this->TestCommand->save($dir, $classFullName, 'php', $content);
        }
    }

    protected function createFillableTestCases(Model $entity)
    {
        $placeholders = [
            '{{CONTENT}}' => sprintf('["%s"]', implode('","', $entity->getFillable())),
            '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
            '{{METHOD}}' => "getFillable()",
            '{{CONSTANT}}' => 'has_fillable'
        ];

        return Str::of($this->TestCommand->getStub('entity-constants-test-case'))->replace(array_keys($placeholders), array_values($placeholders));
    }

    protected function createHiddenTestCases(Model $entity)
    {
        $placeholders = [
            '{{CONTENT}}' => sprintf('["%s"]', implode('","', $entity->getHidden())),
            '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
            '{{METHOD}}' => "getHidden()",
            '{{CONSTANT}}' => 'has_hidden'
        ];

        return Str::of($this->TestCommand->getStub('entity-constants-test-case'))->replace(array_keys($placeholders), array_values($placeholders));
    }

    protected function createTableTestCases(Model $entity)
    {
        $placeholders = [
            '{{CONTENT}}' => sprintf('"%s"', $entity->getTable()),
            '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
            '{{METHOD}}' => "getTable()",
            '{{CONSTANT}}' => 'has_' . Str::plural($this->entityShortName) . '_table'
        ];

        return Str::of($this->TestCommand->getStub('entity-constants-test-case'))->replace(array_keys($placeholders), array_values($placeholders));
    }

    protected function createCastsTestCases(Model $entity)
    {
        $castsTestCases = [];
        $casts = Arr::except($entity->getCasts(), 'id');

        foreach ($casts as $key => $value) {
            $placeholders = [
                '{{CONTENT}}' => sprintf('"%s"', $value),
                '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
                '{{METHOD}}' => sprintf('getCasts()["%s"]', $key),
                '{{CONSTANT}}' =>  sprintf("casts_%s_to_%s", $key, $value),
            ];

            array_push(
                $castsTestCases,
                Str::of($this->TestCommand->getStub('entity-constants-test-case'))
                    ->replace(
                        array_keys($placeholders),
                        array_values($placeholders)
                    )
            );
        }

        return join("\n", $castsTestCases);
    }

    protected function createLogNameTestCases(Model $entity)
    {
        if ($this->entityReflection->hasProperty('logName')) {
            $logName = $this->entityReflection->getProperty('logName');
            $logName->setAccessible(true);
            $logName = $logName->getValue($entity);

            $placeholders = [
                '{{METHOD-NAME}}' => sprintf('log_attributes_with_name_of_%s', Str::lower($logName)),
                '{{CONTENT}}' => sprintf('"%s"', $logName),
                '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
                '{{METHOD}}' => sprintf("getValue(\$this->%s)", Str::lower($this->entityShortName)),
                '{{CONSTANT}}' => 'logName'
            ];

            return Str::of($this->TestCommand->getStub('entity-protected-constants-test-case'))->replace(array_keys($placeholders), array_values($placeholders));
        }
    }

    protected function createLogTestCases(Model $entity)
    {
        if ($this->entityReflection->hasProperty('logAttributes')) {
            $log = $this->entityReflection->getProperty('logAttributes');
            $log->setAccessible(true);
            $log = $log->getValue($entity);

            $placeholders = [
                '{{METHOD-NAME}}' => sprintf('log_all_attributes_of_%s', Str::lower($this->entityShortName)),
                '{{CONTENT}}' => sprintf('["%s"]', $log[0]),
                '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
                '{{METHOD}}' => "getValue()",
                '{{CONSTANT}}' => 'logAttributes'
            ];

            return Str::of($this->TestCommand->getStub('entity-protected-constants-test-case'))->replace(array_keys($placeholders), array_values($placeholders));
        }
    }

    protected function createTraitTestCases(Model $entity)
    {
        $tratisTestCases = [];
        $traits = array_keys($this->entityReflection->getTraits());

        foreach ($traits as $trait) {
            $placeholders = [
                '{{TRAIT_LC}}' => Str::lower(collect(explode('\\', $trait))->last()),
                '{{CONTENT}}' => $trait,
                '{{ENTITY_LC}}' => Str::lower($this->entityShortName),
            ];

            array_push(
                $tratisTestCases,
                Str::of($this->TestCommand->getStub('trait-test-case'))
                    ->replace(
                        array_keys($placeholders),
                        array_values($placeholders)
                    )
            );
        }

        return join("\n", $tratisTestCases);
    }
    public function createJWTMethods()
    {
        $interfaces = array_keys($this->entityReflection->getInterfaces());

        if (!in_array(
            "Tymon\JWTAuth\Contracts\JWTSubject",
            $interfaces
        )) return;

        return Str::of($this->TestCommand->getStub('entity-jwt-test-case'));
    }

    public function createSetupMethod(string $entity)
    {
        $placeholders = [
            '{{ENTITY_LC}}' => Str::lower($entity),
            '{{ENTITY}}' => Str::ucfirst($entity)
        ];

        return Str::of($this->TestCommand->getStub('entity-setup-method'))->replace(array_keys($placeholders), array_values($placeholders));
    }
}
