<?php

namespace App\Http\Controllers;

use App\Models\TipoRecibo;

class TipoReciboController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoRecibo;
        $tabla = 'tipo_recibo';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoRecibo::select('tipo_recibo.*')->orderBy('id', 'ASC')->get();
    }
}
