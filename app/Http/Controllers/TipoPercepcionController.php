<?php

namespace App\Http\Controllers;

use App\Models\TipoPercepcion;

class TipoPercepcionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoPercepcion;
        $tabla = 'tipo_percepcion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoPercepcion::select('tipo_percepcion.*')->orderBy('id', 'ASC')->get();
    }
}
