<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoCuentaBancaria;

class EmpleadoCuentaBancariaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new EmpleadoCuentaBancaria;
        $tabla = 'empleado_cuenta_bancaria';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmpleadoCuentaBancaria::select('empleado_cuenta_bancaria.*')->orderBy('id', 'ASC')->get();
    }
}
