<?php

namespace App\Http\Controllers;

use App\Models\NotaCreditoCancelada;

class NotaCreditoCanceladaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new NotaCreditoCancelada;
        $tabla = 'nota_credito_cancelada';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotaCreditoCancelada::select('nota_credito_cancelada.*')->orderBy('id', 'ASC')->get();
    }
}
