<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepository
{
    /**
     * Get Instance From Specified Entity.
     *
     * @return Model
     */
    public function instance() : Model;

    /**
     * Get All Records From Specified Entity.
     *
     * @return Collection
     */
    public function all() : Collection;

    /**
     * Find Entity By ID.
     *
     * @param  int   $id
     * @return Model
     */
    public function find(int $id) : Model;

    /**
     * Find Many Entities By ID's.
     *
     * @param  array      $ids
     * @return Collection
     */
    public function findMany(array $ids) : Collection;

    /**
     * Find $column Where Equals $value.
     *
     * @param  array $criteria
     * @return Collection
     */
    public function findWhere(array $criteria) : Collection;

    /**
     * Find $column Where Equals $value then get the first value.
     *
     * @param  array $criteria
     * @return Model
     */
    public function findWhereFirst(array $criteria) : Model;

    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 0) : LengthAwarePaginator;

    /**
     * Create New Entity.
     *
     * @param  array $data
     * @return Model
     */
    public function create(array $data) : Model;

    /**
     * Update Entity.
     *
     * @param  integer $id
     * @param  array   $data
     * @return Model
     */
    public function update(int $id, array $data) : Model;

    /**
     * Delete Entity.
     *
     * @param int $id
     * @return boolean
     */
    public function delete(int $id) : bool;

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return BaseRepository
     */
    public function with(...$relations) : BaseRepository;
}
