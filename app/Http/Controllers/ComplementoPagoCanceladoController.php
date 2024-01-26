<?php

namespace App\Http\Controllers;

use App\Models\ComplementoPagoCancelado;

class ComplementoPagoCanceladoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ComplementoPagoCancelado;
        $tabla = 'complemento_pago_cancelado';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplementoPagoCancelado::select('complemento_pago_cancelado.*')->orderBy('id', 'ASC')->get();
    }
}
