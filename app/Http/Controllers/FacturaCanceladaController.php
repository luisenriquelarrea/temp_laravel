<?php

namespace App\Http\Controllers;

use App\Models\FacturaCancelada;

class FacturaCanceladaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new FacturaCancelada;
        $tabla = 'factura_cancelada';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FacturaCancelada::select('factura_cancelada.*')->orderBy('id', 'ASC')->get();
    }
}
