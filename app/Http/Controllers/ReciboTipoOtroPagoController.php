<?php

namespace App\Http\Controllers;

use App\Models\ReciboTipoOtroPago;

class ReciboTipoOtroPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ReciboTipoOtroPago;
        $tabla = 'recibo_tipo_otro_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReciboTipoOtroPago::select('recibo_tipo_otro_pago.*')->orderBy('id', 'ASC')->get();
    }
}
