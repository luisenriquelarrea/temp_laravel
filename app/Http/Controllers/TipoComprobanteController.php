<?php

namespace App\Http\Controllers;

use App\Models\TipoComprobante;

class TipoComprobanteController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new TipoComprobante;
        $tabla = 'tipo_comprobante';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TipoComprobante::select('tipo_comprobante.*')->orderBy('id', 'ASC')->get();
    }
}
