<?php

namespace App\Http\Controllers;

use App\Models\EmpresaPlaza;

class EmpresaPlazaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new EmpresaPlaza;
        $tabla = 'empresa_plaza';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmpresaPlaza::select('empresa_plaza.*')->orderBy('id', 'ASC')->get();
    }
}
