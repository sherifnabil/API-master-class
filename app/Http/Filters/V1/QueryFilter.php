<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    public function __construct(
        protected  Builder $builder,
        protected Request $request
    ) {
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

    public function apply(Builder $builder): void
    {
        $this->builder = $builder;

        if($this->request->get('filter')) {
            $this->filter($this->request->get('filter'));
        }
    }
}
