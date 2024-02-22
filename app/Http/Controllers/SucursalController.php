<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;

class SucursalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Sucursal;
        $tabla = 'sucursal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sucursal::select('sucursal.*')->orderBy('id', 'ASC')->get();
    }
}
