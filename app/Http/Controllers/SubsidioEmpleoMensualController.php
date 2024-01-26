<?php

namespace App\Http\Controllers;

use App\Models\SubsidioEmpleoMensual;

class SubsidioEmpleoMensualController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SubsidioEmpleoMensual;
        $tabla = 'subsidio_empleo_mensual';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubsidioEmpleoMensual::select('subsidio_empleo_mensual.*')->orderBy('id', 'ASC')->get();
    }
}
