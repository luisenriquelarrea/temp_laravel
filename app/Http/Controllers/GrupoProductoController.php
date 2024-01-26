<?php

namespace App\Http\Controllers;

use App\Models\GrupoProducto;

class GrupoProductoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new GrupoProducto;
        $tabla = 'grupo_producto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GrupoProducto::select('grupo_producto.*')->orderBy('id', 'ASC')->get();
    }
}
