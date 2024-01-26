<?php

namespace App\Http\Controllers;

use App\Models\Plaza;

class PlazaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Plaza;
        $tabla = 'plaza';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plaza::select('plaza.*')->orderBy('id', 'ASC')->get();
    }
}
