<?php

namespace App\Http\Controllers;

use App\Models\UsoCfdi;

class UsoCfdiController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new UsoCfdi;
        $tabla = 'uso_cfdi';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsoCfdi::select('uso_cfdi.*')->orderBy('id', 'ASC')->get();
    }
}
