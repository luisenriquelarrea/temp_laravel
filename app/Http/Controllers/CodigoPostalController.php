<?php

namespace App\Http\Controllers;

use App\Models\CodigoPostal;

class CodigoPostalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new CodigoPostal;
        $tabla = 'codigo_postal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CodigoPostal::select('codigo_postal.*')->orderBy('id', 'ASC')->get();
    }
}
