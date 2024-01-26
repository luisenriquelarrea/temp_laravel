<?php

namespace App\Http\Controllers;

use App\Models\Pais;

class PaisController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Pais;
        $tabla = 'pais';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pais::select('pais.*')->orderBy('id', 'ASC')->get();
    }
}
