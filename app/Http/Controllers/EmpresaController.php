<?php

namespace App\Http\Controllers;

use App\Models\Empresa;

class EmpresaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Empresa;
        $tabla = 'empresa';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Empresa::select('empresa.*')->orderBy('id', 'ASC')->get();
    }
}
