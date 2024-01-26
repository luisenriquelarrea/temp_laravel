<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Cliente;
        $tabla = 'cliente';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cliente::select('cliente.*')->orderBy('id', 'ASC')->get();
    }
}
