<?php

namespace App\Http\Controllers;

use App\Models\IsrMensual;

class IsrMensualController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new IsrMensual;
        $tabla = 'isr_mensual';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IsrMensual::select('isr_mensual.*')->orderBy('id', 'ASC')->get();
    }
}
