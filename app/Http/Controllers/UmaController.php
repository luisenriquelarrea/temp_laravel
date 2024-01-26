<?php

namespace App\Http\Controllers;

use App\Models\Uma;

class UmaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Uma;
        $tabla = 'uma';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Uma::select('uma.*')->orderBy('id', 'ASC')->get();
    }
}
