<?php

namespace App\Http\Controllers;

use App\Models\TipoContrato;

class TipoContratoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoContrato;
        $tabla = 'tipo_contrato';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoContrato::select('tipo_contrato.*')->orderBy('id', 'ASC')->get();
    }
}
