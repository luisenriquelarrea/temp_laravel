<?php

namespace App\Http\Controllers;

use App\Models\Banco;

class BancoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Banco;
        $tabla = 'banco';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Banco::select('banco.*')->orderBy('id', 'ASC')->get();
    }
}
