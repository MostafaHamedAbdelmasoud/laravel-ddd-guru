<?php

namespace MostafaHamed\DDD\Helper\Make\Service\Test;

use Illuminate\Support\Str;
use MostafaHamed\DDD\Helper\Make\Maker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormRequestsTestCasesFactory
{
    public $testCommand;
    public $relationClass;
    public $relationMethod;
    public $placeholder;
    private $rule;
    private $existanceRules;
    private $sizeRules;
    private $typeRules;

    public function __construct(string $rule)
    {
        $this->rule = $rule;
        $this->existanceRules = ['required', 'sometimes', 'nullable'];
        $this->sizeRules = ['max', 'min'];
        $this->typeRules = ['string', 'numeric'];
    }

    public function make()
    {
        switch (true) {
            case in_array($this->rule, $this->existanceRules);
                $this->createExistanceRulesTestCases();
                break;
            case in_array($this->rule, $this->existanceRules);
                $this->createSizeRulesTestCases();
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

    public function createExistanceRulesTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{RELATION}}' => 'HasMany',
            '{{RELATION_CC}}' => 'has_many',
            '{{LocalKeyName}}' => $this->relationClass->{$this->relationMethod}()->getLocalKeyName(),
            '{{ForeignKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignKeyName()
        ];

        $this->stub = 'request-existance-test-cases-methods';
    }

    public function createSizeRulesTestCases()
    {
        $this->placeholder = [
            '{{RELATED_MODEL}}' => $this->relationMethod,
            '{{RELATION}}' => 'HasOne',
            '{{RELATION_CC}}' => 'has_one',
            '{{LocalKeyName}}' => $this->relationClass->{$this->relationMethod}()->getLocalKeyName(),
            '{{ForeignKeyName}}' => $this->relationClass->{$this->relationMethod}()->getForeignKeyName()
        ];

        $this->stub = 'request-size-test-cases-methods';
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
