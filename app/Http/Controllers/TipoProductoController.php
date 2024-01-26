<?php

namespace App\Http\Controllers;

use App\Models\TipoProducto;

class TipoProductoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoProducto;
        $tabla = 'tipo_producto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoProducto::select('tipo_producto.*')->orderBy('id', 'ASC')->get();
    }
}
