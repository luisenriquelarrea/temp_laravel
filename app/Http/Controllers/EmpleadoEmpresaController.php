<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoEmpresa;

class EmpleadoEmpresaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new EmpleadoEmpresa;
        $tabla = 'empleado_empresa';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmpleadoEmpresa::select('empleado_empresa.*')->orderBy('id', 'ASC')->get();
    }
}
