<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;

class IncapacidadController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Incapacidad;
        $tabla = 'incapacidad';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Incapacidad::select('incapacidad.*')->orderBy('id', 'ASC')->get();
    }
}
