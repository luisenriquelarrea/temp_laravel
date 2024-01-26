<?php

namespace App\Http\Controllers;

use App\Models\SerieCfdi;

class SerieCfdiController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SerieCfdi;
        $tabla = 'serie_cfdi';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SerieCfdi::select('serie_cfdi.*')->orderBy('id', 'ASC')->get();
    }
}
