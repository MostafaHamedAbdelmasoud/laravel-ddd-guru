<?php

namespace App\Infrastructure\Traits;

use App\Infrastructure\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

trait CanBeScoped
{
    /**
     * @param Builder $builder
     * @param array $scopes
     */
    public function scopeWithScopes(Builder $builder, $scopes = [])
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }
}
