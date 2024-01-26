<?php

namespace App\Http\Controllers;

use App\Models\SubsidioEmpleoQuincenal;

class SubsidioEmpleoQuincenalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SubsidioEmpleoQuincenal;
        $tabla = 'subsidio_empleo_quincenal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubsidioEmpleoQuincenal::select('subsidio_empleo_quincenal.*')->orderBy('id', 'ASC')->get();
    }
}
