<?php

namespace App\Http\Controllers;

use App\Models\ReciboDeduccion;

class ReciboDeduccionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ReciboDeduccion;
        $tabla = 'recibo_deduccion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReciboDeduccion::select('recibo_deduccion.*')->orderBy('id', 'ASC')->get();
    }
}
