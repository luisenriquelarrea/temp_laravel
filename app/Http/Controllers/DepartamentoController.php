<?php

namespace App\Http\Controllers;

use App\Models\Departamento;

class DepartamentoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Departamento;
        $tabla = 'departamento';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Departamento::select('departamento.*')->orderBy('id', 'ASC')->get();
    }
}
