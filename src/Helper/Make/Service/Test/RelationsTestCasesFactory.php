<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Make\Maker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RelationsTestCasesFactory
{
    public $testCommand;
    public $relationClass;
    public $relationMethod;
    public $placeholder;
    public $stub;

    public function __construct(Maker $testCommand, Model $relationClass, string $relationMethod)
    {
        $this->testCommand = $testCommand;
        $this->relationClass = $relationClass;
        $this->relationMethod = Str::lower($relationMethod);
    }

    public function make()
    {
        switch (get_class($this->relationClass->{$this->relationMethod}())) {
            case HasMany::class:
                $this->createHasManyTestCases();
                break;

            case HasOne::class:
                $this->createHasOneTestCases();
                break;

            case BelongsTo::class:
                $this->createBelongsToTestCases();
                break;

            case BelongsToMany::class;
                $this->createBelongsToManyTestCases();
                break;

            default:
                return $this->createDefault();
        }

        return Str::of($this->testCommand->getStub($this->stub))
            ->replace(
                array_keys($this->placeholder),
                array_values($this->placeholder)
            );
    }

    public function createHasManyTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{RELATION}}' => 'HasMany',
            '{{RELATION_CC}}' => 'has_many',
            '{{LocalKeyName}}' => $this->relationClass->{$this->relationMethod}()->getLocalKeyName(),
            '{{ForeignKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignKeyName()
        ];

        $this->stub = 'entity-relations-has-methods';
    }

    public function createHasOneTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{RELATION}}' => 'HasOne',
            '{{RELATION_CC}}' => 'has_one',
            '{{LocalKeyName}}' => $this->relationClass->{$this->relationMethod}()->getLocalKeyName(),
            '{{ForeignKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignKeyName()
        ];

        $this->stub = 'entity-relations-has-methods';
    }

    public function createBelongsToTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{OwnerKeyName}}' => $this->relationClass->{$this->relationMethod}()->getOwnerKeyName(),
            '{{ForeignKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignKeyName()
        ];

        $this->stub = 'entity-relations-belongs-to-methods';
    }

    public function createBelongsToManyTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{PIVOT_TABLE}}' =>  $this->relationClass->{$this->relationMethod}()->getTable(),
            '{{ForeignPivotKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignPivotKeyName(),
            '{{RelatedPivotKeyName}}' => $this->relationClass->{$this->relationMethod}()->getRelatedPivotKeyName()
        ];

        $this->stub = 'entity-relations-belongs-to-many-methods';
    }

    public function createDefault()
    {
        return "";
    }
}
