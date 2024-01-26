<?php

namespace App\Http\Controllers;

use App\Models\Moneda;

class MonedaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Moneda;
        $tabla = 'moneda';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Moneda::select('moneda.*')->orderBy('id', 'ASC')->get();
    }
}
