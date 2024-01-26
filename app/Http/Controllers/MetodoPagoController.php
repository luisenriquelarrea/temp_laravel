<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new MetodoPago;
        $tabla = 'metodo_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MetodoPago::select('metodo_pago.*')->orderBy('id', 'ASC')->get();
    }
}
