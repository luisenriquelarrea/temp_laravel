<?php

namespace App\Http\Controllers;

use App\Models\ComplementoPago;

class ComplementoPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ComplementoPago;
        $tabla = 'complemento_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplementoPago::select('complemento_pago.*')->orderBy('id', 'ASC')->get();
    }
}
