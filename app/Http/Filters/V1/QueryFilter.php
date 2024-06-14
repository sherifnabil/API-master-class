<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected array $sortable = [];

    public function __construct(
        protected  Builder $builder,
        protected Request $request,
    ) {
    }

    public function apply(Builder $builder): void
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }
    }

    protected function filter(array $filters)
    {
        foreach ($filters as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort($value)
    {
        $sortAttributes = explode(',', $value);
        foreach ($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if((strpos($sortAttribute, '-') === 0)) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if((! in_array($sortAttribute, $this->sortable)) && (! array_key_exists($sortAttribute, $this->sortable))) continue;

            $columnName = $this->sortable[$sortAttribute] ??= $sortAttribute;

            $this->builder->orderBy($columnName, $direction);
        }
    }
}
