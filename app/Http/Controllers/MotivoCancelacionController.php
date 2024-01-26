<?php

namespace App\Http\Controllers;

use App\Models\MotivoCancelacion;

class MotivoCancelacionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new MotivoCancelacion;
        $tabla = 'motivo_cancelacion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MotivoCancelacion::select('motivo_cancelacion.*')->orderBy('id', 'ASC')->get();
    }
}
