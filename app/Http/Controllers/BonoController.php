<?php

namespace App\Http\Controllers;

use App\Models\Bono;

class BonoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Bono;
        $tabla = 'bono';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bono::select('bono.*')->orderBy('id', 'ASC')->get();
    }
}
