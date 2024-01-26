<?php

namespace App\Http\Controllers;

use App\Models\PeriodoPago;

class PeriodoPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new PeriodoPago;
        $tabla = 'periodo_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PeriodoPago::select('periodo_pago.*')->orderBy('id', 'ASC')->get();
    }
}
