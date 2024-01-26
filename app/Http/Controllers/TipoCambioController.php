<?php

namespace App\Http\Controllers;

use App\Models\TipoCambio;

class TipoCambioController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoCambio;
        $tabla = 'tipo_cambio';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoCambio::select('tipo_cambio.*')->orderBy('id', 'ASC')->get();
    }
}
