<?php

namespace App\Http\Controllers;

use App\Models\SubsidioEmpleoSemanal;

class SubsidioEmpleoSemanalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SubsidioEmpleoSemanal;
        $tabla = 'subsidio_empleo_semanal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubsidioEmpleoSemanal::select('subsidio_empleo_semanal.*')->orderBy('id', 'ASC')->get();
    }
}
