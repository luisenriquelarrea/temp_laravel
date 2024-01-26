<?php

namespace App\Http\Controllers;

use App\Models\CalculoNomina;

class CalculoNominaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new CalculoNomina;
        $tabla = 'calculo_nomina';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CalculoNomina::select('calculo_nomina.*')->orderBy('id', 'ASC')->get();
    }
}
