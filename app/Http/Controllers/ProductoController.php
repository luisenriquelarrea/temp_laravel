<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Producto;
        $tabla = 'producto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Producto::select('producto.*')->orderBy('id', 'ASC')->get();
    }
}
