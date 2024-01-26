<?php

namespace App\Http\Controllers;

use App\Models\PrenominaDetalle;

class PrenominaDetalleController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new PrenominaDetalle;
        $tabla = 'prenomina_detalle';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PrenominaDetalle::select('prenomina_detalle.*')->orderBy('id', 'ASC')->get();
    }
}
