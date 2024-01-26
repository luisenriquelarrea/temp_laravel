<?php

namespace App\Http\Controllers;

use App\Models\RegistroPatronal;

class RegistroPatronalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new RegistroPatronal;
        $tabla = 'registro_patronal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RegistroPatronal::select('registro_patronal.*')->orderBy('id', 'ASC')->get();
    }
}
