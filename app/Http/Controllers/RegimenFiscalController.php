<?php

namespace App\Http\Controllers;

use App\Models\RegimenFiscal;

class RegimenFiscalController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new RegimenFiscal;
        $tabla = 'regimen_fiscal';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RegimenFiscal::select('regimen_fiscal.*')->orderBy('id', 'ASC')->get();
    }
}
