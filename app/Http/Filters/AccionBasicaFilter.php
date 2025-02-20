<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AccionBasicaFilter {
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        if ($this->request->has('descripcion'))
            $this->filterByDescripcion($this->request->input('descripcion'));

        return $this->paginate();
    }

    protected function paginate()
    {
        $limit = is_numeric($this->request->input('limit')) ? $this->request->input('limit') : 30;
        return $this->builder->paginate($limit);
    }

    protected function filterByDescripcion($descripcion)
    {
        return $this->builder->where('descripcion', 'like', '%'.$descripcion.'%');
    }
}