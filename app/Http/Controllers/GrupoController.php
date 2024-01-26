<?php

namespace App\Http\Controllers;

use App\Models\Grupo;

class GrupoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Grupo;
        $tabla = 'grupo';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Grupo::select('grupo.*')->orderBy('id', 'ASC')->get();
    }

}
