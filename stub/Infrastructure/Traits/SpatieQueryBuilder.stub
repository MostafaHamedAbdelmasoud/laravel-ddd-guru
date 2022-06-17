<?php

namespace App\Infrastructure\Traits;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait SpatieQueryBuilder
{
    /**
     * Get All Records From Spescfied Entity.
     *
     * @return Collection
     */
    public function iall() : Collection
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts)->get();
    }

    /**
     * Paginate.
     *
     * @param  integer   $limit
     * @return Paginator
     */
    public function ipaginate() : LengthAwarePaginator
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts)->paginate($this->limit);
    }

    /**
     * Find Entity By ID.
     *
     * @param  int   $id
     * @return Model
     */
    public function ifind(int $id): Model
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->where(['id' => $id])->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts)->firstOrFail();
    }

    /**
     * Find Many Entities By ID's.
     *
     * @param  array      $ids
     * @return Collection
     */
    public function ifindMany(array $ids) : Collection
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->whereIn('id', $ids)->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts)->get();
    }

    /**
     * Find $column Where Equals $value.
     *
     * @param  array $createria
     * @return Illuminate\Support\Collection
     */
    public function ifindWhere(array $createria) : Collection
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->where($criteria)->allowedIncludes($this->allowedIncludes)->get();
    }

    /**
     * Find $column Where Equals $value then get the first value.
     *
     * @param  array $createria
     * @return Model
     */
    public function ifindWhereFirst(array $createria) : Model
    {
        return QueryBuilder::for($this->entity->getMorphClass())->with($this->relations)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedAppends($this->allowedAppends)->where($criteria)->allowedIncludes($this->allowedIncludes)->firstOrFail();
    }
}
