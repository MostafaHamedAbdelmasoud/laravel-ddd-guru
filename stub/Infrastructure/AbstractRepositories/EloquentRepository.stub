<?php
namespace App\Infrastructure\AbstractRepositories;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Container\Container as Application;
abstract class EloquentRepository extends BaseRepository
{
    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedFilters = [];

    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedFiltersExact = [];

    /**
     * Allowed Fields.
     *
     * @var array
     */
    protected $allowedFields = [];

    /**
     * Allowed Appends.
     *
     * @var array
     */
    protected $allowedAppends = [];

    /**
     * Allowed Sorts.
     *
     * @var array
     */
    protected $allowedSorts = [];

    /**
     * @param Application $app
     */
    public function spatie()
    {
        foreach ($this->allowedFiltersExact as $field) {
            array_push($this->allowedFilters, AllowedFilter::exact($field));
        }
        if ($this->model instanceof Builder) {
            $this->model = QueryBuilder::for($this->model)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedIncludes($this->allowedIncludes);
        } else {
            $query = app()->make($this->model())->newQuery();
            $this->model = QueryBuilder::for($query)->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedIncludes($this->allowedIncludes);
        }
        return $this;
    }
    /**
     * Retrieve all data of repository.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        if ($this->model instanceof Builder || $this->model instanceof QueryBuilder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }
        $this->resetModel();
        $this->resetScope();
        return $this->parserResult($results);
    }
}