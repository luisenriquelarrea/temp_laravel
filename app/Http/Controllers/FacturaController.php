<?php

namespace App\Http\Controllers;

use App\Models\Factura;

class FacturaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Factura;
        $tabla = 'factura';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Factura::select('factura.*')->orderBy('id', 'ASC')->get();
    }
}
