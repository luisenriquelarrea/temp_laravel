<?php

namespace App\Http\Controllers;

use App\Models\TipoNomina;

class TipoNominaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoNomina;
        $tabla = 'tipo_nomina';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoNomina::select('tipo_nomina.*')->orderBy('id', 'ASC')->get();
    }
}
