<?php

namespace App\Http\Controllers;

use App\Models\RiesgoPuesto;

class RiesgoPuestoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new RiesgoPuesto;
        $tabla = 'riesgo_puesto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RiesgoPuesto::select('riesgo_puesto.*')->orderBy('id', 'ASC')->get();
    }
}
