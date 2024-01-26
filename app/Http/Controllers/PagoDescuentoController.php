<?php

namespace App\Http\Controllers;

use App\Models\PagoDescuento;

class PagoDescuentoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new PagoDescuento;
        $tabla = 'pago_descuento';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PagoDescuento::select('pago_descuento.*')->orderBy('id', 'ASC')->get();
    }
}
