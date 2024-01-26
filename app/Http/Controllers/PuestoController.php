<?php

namespace App\Http\Controllers;

use App\Models\Puesto;

class PuestoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Puesto;
        $tabla = 'puesto';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Puesto::select('puesto.*')->orderBy('id', 'ASC')->get();
    }
}
