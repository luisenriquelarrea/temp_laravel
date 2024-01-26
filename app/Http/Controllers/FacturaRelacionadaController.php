<?php

namespace App\Http\Controllers;

use App\Models\FacturaRelacionada;

class FacturaRelacionadaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new FacturaRelacionada;
        $tabla = 'factura_relacionada';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FacturaRelacionada::select('factura_relacionada.*')->orderBy('id', 'ASC')->get();
    }
}
