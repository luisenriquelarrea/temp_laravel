<?php

namespace App\Http\Controllers;

use App\Models\SalarioMinimo;

class SalarioMinimoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SalarioMinimo;
        $tabla = 'salario_minimo';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SalarioMinimo::select('salario_minimo.*')->orderBy('id', 'ASC')->get();
    }
}
