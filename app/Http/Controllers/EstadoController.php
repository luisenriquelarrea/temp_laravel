<?php

namespace App\Http\Controllers;

use App\Models\Estado;

class EstadoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Estado;
        $tabla = 'estado';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Estado::select('estado.*')->orderBy('id', 'ASC')->get();
    }
}
