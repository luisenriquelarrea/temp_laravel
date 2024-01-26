<?php

namespace App\Http\Controllers;

use App\Models\IsrQuincenal;

class IsrQuincenalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new IsrQuincenal;
        $tabla = 'isr_quincenal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IsrQuincenal::select('isr_quincenal.*')->orderBy('id', 'ASC')->get();
    }
}
