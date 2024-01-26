<?php

namespace App\Http\Controllers;

use App\Models\Deduccion;

class DeduccionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Deduccion;
        $tabla = 'deduccion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Deduccion::select('deduccion.*')->orderBy('id', 'ASC')->get();
    }
}
