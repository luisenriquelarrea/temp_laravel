<?php

namespace App\Http\Controllers;

use App\Models\TipoJornada;

class TipoJornadaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoJornada;
        $tabla = 'tipo_jornada';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoJornada::select('tipo_jornada.*')->orderBy('id', 'ASC')->get();
    }
}
