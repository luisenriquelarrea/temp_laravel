<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use Illuminate\Http\Request;

class AccionController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Accion;
        $tabla = 'accion';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Accion::select('accion.*')->orderBy('id', 'ASC')->get();
    }
}
