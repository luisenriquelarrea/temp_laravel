<?php

namespace App\Http\Controllers;

use App\Models\Percepcion;

class PercepcionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Percepcion;
        $tabla = 'percepcion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Percepcion::select('percepcion.*')->orderBy('id', 'ASC')->get();
    }
}
