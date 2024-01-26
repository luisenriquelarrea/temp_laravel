<?php

namespace App\Http\Controllers;

use App\Models\TipoRelacion;

class TipoRelacionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoRelacion;
        $tabla = 'tipo_relacion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoRelacion::select('tipo_relacion.*')->orderBy('id', 'ASC')->get();
    }
}
