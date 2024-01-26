<?php

namespace App\Http\Controllers;

use App\Models\Nomina;

class NominaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Nomina;
        $tabla = 'nomina';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Nomina::select('nomina.*')->orderBy('id', 'ASC')->get();
    }
}
