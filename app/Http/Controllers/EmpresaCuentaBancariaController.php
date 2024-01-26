<?php

namespace App\Http\Controllers;

use App\Models\EmpresaCuentaBancaria;
use Illuminate\Http\Request;

class EmpresaCuentaBancariaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new EmpresaCuentaBancaria;
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
        return EmpresaCuentaBancaria::select('empresa_cuenta_bancaria.*')->orderBy('id', 'ASC')->get();
    }
}
