<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SeccionMenuInputFilter {
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        if ($this->request->has('seccion_menu_id'))
            $this->filterBySeccionMenuId($this->request->input('seccion_menu_id'));

        return $this->paginate();
    }

    protected function paginate()
    {
        $limit = is_numeric($this->request->input('limit')) ? $this->request->input('limit') : 30;
        return $this->builder->paginate($limit);
    }

    protected function filterBySeccionMenuId($seccionMenuId)
    {
        return $this->builder->where('seccion_menu.id', '=', $seccionMenuId);
    }
}