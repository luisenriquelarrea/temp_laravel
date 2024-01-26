<?php

namespace App\Http\Controllers;

use App\Models\Descuento;

class DescuentoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Descuento;
        $tabla = 'descuento';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Descuento::select('descuento.*')->orderBy('id', 'ASC')->get();
    }
}
