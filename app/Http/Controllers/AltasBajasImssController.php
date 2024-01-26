<?php

namespace App\Http\Controllers;

use App\Models\AltasBajasImss;
use Illuminate\Http\Request;
use App\Http\Traits\MethodResponseTrait;

class AltasBajasImssController extends Controller
{
    use MethodResponseTrait {
        set_error as protected error_response;
        set_success as protected success_response;
    }

    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new AltasBajasImss;
        $tabla = 'altas_bajas_imss';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AltasBajasImss::select('altas_bajas_imss.*')->orderBy('id', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $override = false)
    {
        if(!isset($request->data['movimiento']) || (string)trim($request->data['movimiento']) === ''){
            $error = $this->error_response('Error $request->data[movimiento] debe estar asignado', 
                __CLASS__, __FUNCTION__, __LINE__);
            return response()->json($error, 500);
        }
        $movimiento = strtolower(trim($request->data['movimiento']));
    }
}
