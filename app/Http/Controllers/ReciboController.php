<?php

namespace App\Http\Controllers;

use App\Models\Recibo;

class ReciboController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Recibo;
        $tabla = 'recibo';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recibo::select('recibo.*')->orderBy('id', 'ASC')->get();
    }
}
