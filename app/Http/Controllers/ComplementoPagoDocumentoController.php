<?php

namespace App\Http\Controllers;

use App\Models\ComplementoPagoDocumento;

class ComplementoPagoDocumentoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new ComplementoPagoDocumento;
        $tabla = 'complemento_pago_documento';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplementoPagoDocumento::select('complemento_pago_documento.*')->orderBy('id', 'ASC')->get();
    }
}
