<?php

namespace App\Http\Controllers;

use App\Models\TipoIncapacidad;

class TipoIncapacidadController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoIncapacidad;
        $tabla = 'tipo_incapacidad';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoIncapacidad::select('tipo_incapacidad.*')->orderBy('id', 'ASC')->get();
    }
}
