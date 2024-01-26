<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new Empleado;
        $tabla = 'empleado';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Empleado::select('empleado.*', 'plaza.descripcion AS plaza_descripcion')
            ->join('plaza', 'plaza.id', '=', 'empleado.plaza_id')
            ->orderBy('empleado.id', 'ASC')
            ->get();
    }

    /**
     * Display a listing of the resource filtered by params.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_filtered(Request $request)
    {
        $seccion_menu_id = $request->input('seccion_menu_id');
        $column = 'filtro';
        $inputs_filtro_data = $this->inputs($seccion_menu_id, $column)->toArray();
        if(sizeof($inputs_filtro_data) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no existe informacion seccion_menu_input filtro',
            ];
            return response()->json($response, 500);
        }
        $query = Empleado::select('empleado.*', 'plaza.descripcion AS plaza_descripcion');
        foreach($inputs_filtro_data as $key => $valor){
            $input_modelo = $valor['modelo'];
            $input_id = $valor['input_id'];
            if(trim((string)$request->input($input_id)) !== ''){
                $search = trim((string)$request->input($input_id));
                $key = $input_modelo.'.'.$input_id;
                $query->where($key, 'LIKE', '%'.$search.'%');
            }
        }
        return $query->join('plaza', 'plaza.id', '=', 'empleado.plaza_id')
            ->orderBy('empleado.id', 'ASC')
            ->get();
    }
}
