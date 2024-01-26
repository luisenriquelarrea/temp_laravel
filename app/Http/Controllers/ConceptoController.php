<?php

namespace App\Http\Controllers;

use App\Models\Concepto;

class ConceptoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Concepto;
        $tabla = 'concepto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Concepto::select('concepto.*')->orderBy('id', 'ASC')->get();
    }
}
