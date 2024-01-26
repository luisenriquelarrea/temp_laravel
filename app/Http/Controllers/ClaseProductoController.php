<?php

namespace App\Http\Controllers;

use App\Models\ClaseProducto;

class ClaseProductoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ClaseProducto;
        $tabla = 'clase_producto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClaseProducto::select('clase_producto.*')->orderBy('id', 'ASC')->get();
    }
}
