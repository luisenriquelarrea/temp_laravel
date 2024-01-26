<?php

namespace App\Http\Controllers;

use App\Models\PeriodicidadPago;

class PeriodicidadPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new PeriodicidadPago;
        $tabla = 'periodicidad_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PeriodicidadPago::select('periodicidad_pago.*')->orderBy('id', 'ASC')->get();
    }
}
