<?php

namespace App\Http\Controllers;

use App\Models\Prenomina;

class PrenominaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Prenomina;
        $tabla = 'prenomina';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Prenomina::select('prenomina.*')->orderBy('id', 'ASC')->get();
    }
}
