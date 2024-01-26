<?php

namespace App\Http\Controllers;

use App\Models\NotaCreditoDocumento;

class NotaCreditoDocumentoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new NotaCreditoDocumento;
        $tabla = 'nota_credito_documento';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotaCreditoDocumento::select('nota_credito_documento.*')->orderBy('id', 'ASC')->get();
    }
}
