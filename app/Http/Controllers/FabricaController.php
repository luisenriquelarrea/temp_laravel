<?php

namespace App\Http\Controllers;

use App\Models\Fabrica;

class FabricaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Fabrica;
        $tabla = 'fabrica';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fabrica::select('fabrica.*')->orderBy('id', 'ASC')->get();
    }
}
