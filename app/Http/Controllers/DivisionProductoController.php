<?php

namespace App\Http\Controllers;

use App\Models\DivisionProducto;

class DivisionProductoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new DivisionProducto;
        $tabla = 'division_producto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DivisionProducto::select('division_producto.*')->orderBy('id', 'ASC')->get();
    }
}
