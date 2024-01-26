<?php

namespace App\Http\Controllers;

use App\Models\PagoBono;

class PagoBonoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new PagoBono;
        $tabla = 'pago_bono';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PagoBono::select('pago_bono.*')->orderBy('id', 'ASC')->get();
    }
}
