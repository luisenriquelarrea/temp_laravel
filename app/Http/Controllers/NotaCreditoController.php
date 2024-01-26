<?php

namespace App\Http\Controllers;

use App\Models\NotaCredito;

class NotaCreditoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new NotaCredito;
        $tabla = 'nota_credito';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotaCredito::select('nota_credito.*')->orderBy('id', 'ASC')->get();
    }
}
