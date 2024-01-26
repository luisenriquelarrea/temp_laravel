<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;

class EjercicioController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Ejercicio;
        $tabla = 'ejercicio';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ejercicio::select('ejercicio.*')->orderBy('id', 'ASC')->get();
    }
}
