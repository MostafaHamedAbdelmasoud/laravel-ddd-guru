<?php

namespace App\Infrastructure\Scoping;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Infrastructure\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class Scoper
{
    /**
     * @var mixed
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @param array $scopes
     * @return mixed
     */
    public function apply(Builder $builder, array $scopes)
    {
        foreach ($this->limitScopes($scopes) as $key => $scope) {
            if (!$scope instanceof Scope) {
                continue;
            }
            $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }

    /**
     * @param array $scopes
     */
    protected function limitScopes(array $scopes)
    {
        return Arr::only(
            $scopes,
            array_keys($this->request->all())
        );
    }
}