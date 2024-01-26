<?php

namespace App\Http\Controllers;

use App\Models\IsrSemanal;

class IsrSemanalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new IsrSemanal;
        $tabla = 'isr_semanal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IsrSemanal::select('isr_semanal.*')->orderBy('id', 'ASC')->get();
    }
}
