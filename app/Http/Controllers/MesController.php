<?php

namespace App\Http\Controllers;

use App\Models\Mes;

class MesController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Mes;
        $tabla = 'mes';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Mes::select('mes.*')->orderBy('id', 'ASC')->get();
    }
}
