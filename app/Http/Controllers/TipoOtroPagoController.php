<?php

namespace App\Http\Controllers;

use App\Models\TipoOtroPago;

class TipoOtroPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoOtroPago;
        $tabla = 'tipo_otro_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoOtroPago::select('tipo_otro_pago.*')->orderBy('id', 'ASC')->get();
    }
}
