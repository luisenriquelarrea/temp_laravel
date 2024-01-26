<?php

namespace App\Http\Controllers;

use App\Models\FacturaConcepto;

class FacturaConceptoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new FacturaConcepto;
        $tabla = 'factura_concepto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FacturaConcepto::select('factura_concepto.*')->orderBy('id', 'ASC')->get();
    }
}
