<?php

namespace App\Http\Controllers;

use App\Models\ReciboPercepcion;

class ReciboPercepcionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ReciboPercepcion;
        $tabla = 'recibo_percepcion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReciboPercepcion::select('recibo_percepcion.*')->orderBy('id', 'ASC')->get();
    }
}
