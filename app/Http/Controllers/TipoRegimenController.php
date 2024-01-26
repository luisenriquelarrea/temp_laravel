<?php

namespace App\Http\Controllers;

use App\Models\TipoRegimen;

class TipoRegimenController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoRegimen;
        $tabla = 'tipo_regimen';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoRegimen::select('tipo_regimen.*')->orderBy('id', 'ASC')->get();
    }
}
