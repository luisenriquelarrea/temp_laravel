<?php

namespace App\Http\Controllers;

use App\Models\FormaPago;

class FormaPagoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new FormaPago;
        $tabla = 'forma_pago';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FormaPago::select('forma_pago.*')->orderBy('id', 'ASC')->get();
    }
}
