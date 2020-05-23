<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Filters\QueryFilter;

class QueryBuilder extends Builder
{
    private $filters;

    public function applyFilters(array $data = null)
    {
        return $this->filterBy($this->newQueryFilter(), $data ?: request()->all());
    }

    protected function newQueryFilter()
    {
        if (method_exists($this->model, 'newQueryFilter')) {
            return $this->model->newQueryFilter();
        }
        if (class_exists($filtersClass = '\App\Filters\\' . class_basename($this->model) . 'Filter')) {
            return new $filtersClass;
        }
        throw new \BadMethodCallException(
            sprintf('No query filter in Model [%s]', get_class($this->model))
        );
    }

    public function filterBy(QueryFilter $filters, array $data)
    {
        $this->filters = $filters;
        return $filters->applyTo($this, $data);
    }

    public function whereQuery($subQuery, $operator, $value = null)
    {
        $this->addBinding($subQuery->getBindings());
        $this->where(DB::raw("({$subQuery->toSql()})"), $operator, $value);
        return $this;
    }

    public function onlyTrashedIf($value)
    {
        if ($value) {
            $this->onlyTrashed();
        }
        return $this;
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = parent::paginate($perPage, $columns, $pageName, $page);
        if ($this->filters) {
            $paginator->appends($this->filters->valid());
        }
        return $paginator;
    }
}