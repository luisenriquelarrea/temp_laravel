<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AccionGrupoFilter {
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        if ($this->request->has('accionDesc'))
            $this->filterByAccionDescripcion($this->request->input('accionDesc'));

        if ($this->request->has('seccionMenuDesc'))
            $this->filterBySeccionMenuDesc($this->request->input('seccionMenuDesc'));

        if ($this->request->has('seccion_menu_id'))
            $this->filterBySeccionMenuId($this->request->input('seccion_menu_id'));

        if ($this->request->has('grupoDesc'))
            $this->filterByGrupoDescripcion($this->request->input('grupoDesc'));

        if ($this->request->has('grupo_id'))
            $this->filterByGrupoId($this->request->input('grupo_id'));

        if ($this->request->has('accionGrupoStatus'))
            $this->filterByAccionGrupoStatus($this->request->input('accionGrupoStatus'));

        if ($this->request->has('accionStatus'))
            $this->filterByAccionStatus($this->request->input('accionStatus'));

        if ($this->request->has('grupoStatus'))
            $this->filterByGrupoStatus($this->request->input('grupoStatus'));

        if ($this->request->has('seccionMenuStatus'))
            $this->filterBySeccionMenuStatus($this->request->input('seccionMenuStatus'));

        if ($this->request->has('accionOnNavbar'))
            $this->filterByAccionOnNavbar($this->request->input('accionOnNavbar'));

        if ($this->request->has('accionOnTable'))
            $this->filterByAccionOnTable($this->request->input('accionOnTable'));

        return $this->paginate();
    }

    protected function paginate()
    {
        $limit = is_numeric($this->request->input('limit')) ? $this->request->input('limit') : 30;
        return $this->builder->paginate($limit);
    }

    protected function filterByAccionDescripcion($accionDesc)
    {
        return $this->builder->where('accion.descripcion', 'like', '%'.$accionDesc.'%');
    }

    protected function filterByGrupoDescripcion($grupoDesc)
    {
        return $this->builder->where('grupo.descripcion', 'like', '%'.$grupoDesc.'%');
    }

    protected function filterByGrupoId($grupoId)
    {
        return $this->builder->where('grupo.id', '=', $grupoId);
    }
    
    protected function filterBySeccionMenuId($seccionMenuId)
    {
        return $this->builder->where('seccion_menu.id', '=', $seccionMenuId);
    }

    protected function filterBySeccionMenuDesc($seccionMenuDesc)
    {
        return $this->builder->where('seccion_menu.descripcion', 'like', '%'.$seccionMenuDesc.'%');
    }

    protected function filterByAccionGrupoStatus($accionGrupoStatus)
    {
        return $this->builder->where('accion_grupo.status', '=', $accionGrupoStatus);
    }

    protected function filterByAccionStatus($accionStatus)
    {
        return $this->builder->where('accion.status', '=', $accionStatus);
    }

    protected function filterByGrupoStatus($grupoStatus)
    {
        return $this->builder->where('grupo.status', '=', $grupoStatus);
    }

    protected function filterBySeccionMenuStatus($seccionMenuStatus)
    {
        return $this->builder->where('seccion_menu.status', '=', $seccionMenuStatus);
    }

    protected function filterByAccionOnNavbar($accionOnNavbar)
    {
        return $this->builder->where('accion.on_navbar', '=', $accionOnNavbar);
    }

    protected function filterByAccionOnTable($accionOnTable)
    {
        return $this->builder->where('accion.on_table', '=', $accionOnTable);
    }
}