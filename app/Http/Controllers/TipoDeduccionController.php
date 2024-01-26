<?php

namespace App\Http\Controllers;

use App\Models\TipoDeduccion;

class TipoDeduccionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoDeduccion;
        $tabla = 'tipo_deduccion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoDeduccion::select('tipo_deduccion.*')->orderBy('id', 'ASC')->get();
    }
}
