<?php

namespace App\Http\Controllers;

use App\Models\AccionBasica;

class AccionBasicaController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new AccionBasica;
        $tabla = 'accion_basica';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AccionBasica::select('accion_basica.*')->orderBy('id', 'ASC')->get();
    }

    /**
     * Display a listing of the resource where on_navbar = 1.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_accion_navbar()
    {
        return AccionBasica::select('accion_basica.id', 'accion_basica.descripcion', 
            'accion_basica.call_method')
            ->where('accion_basica.on_navbar', '=', 1)
            ->orderBy('id', 'ASC')
            ->get();
    }
}
