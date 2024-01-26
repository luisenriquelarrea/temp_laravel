<?php

namespace App\Http\Controllers;

use App\Models\Municipio;

class MunicipioController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Municipio;
        $tabla = 'municipio';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Municipio::select('municipio.*')->orderBy('id', 'ASC')->get();
    }
}
