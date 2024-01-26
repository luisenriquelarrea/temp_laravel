<?php

namespace App\Http\Controllers;

use App\Models\Unidad;

class UnidadController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Unidad;
        $tabla = 'unidad';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Unidad::select('unidad.*')->orderBy('id', 'ASC')->get();
    }
}
