<?php

namespace App\Http\Controllers;

use App\Models\Exportacion;

class ExportacionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Exportacion;
        $tabla = 'exportacion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Exportacion::select('exportacion.*')->orderBy('id', 'ASC')->get();
    }
}
