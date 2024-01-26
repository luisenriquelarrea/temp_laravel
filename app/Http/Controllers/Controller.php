<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Traits\SeccionMenuTrait;
use App\Http\Traits\SeccionMenuInputTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use SeccionMenuTrait {
        seccion_menu_data as protected seccion_menu;
    }
    use SeccionMenuInputTrait {
        get_inputs as protected inputs;
    }

    public $modelo;
    public $tabla;

    /**
     * Constructor.
     *
     * @param App\Models\ 
     * @param string $tabla
     */
    public function __construct($modelo, string $tabla){
        $this->modelo = $modelo;
        $this->tabla = $tabla;
    }

    /**
     * Group array data by value into array.
     * 
     * @param array registros
     * @param string column
     * @return array array_grouped
     */
    public function group_data(array $registros, string $column):array{
        $array_grouped = [];
        foreach ($registros as $k => $item) {
            $array_grouped[$item[$column]][$k] = $item;
        }
        ksort($array_grouped, SORT_NUMERIC);
        return $array_grouped;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $registro = $this->modelo->find($id);
        if($registro){
            $registro->delete();
            $response = [
                'success' => true,
                'message' => 'exito',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'Error al eliminar registro',
        ];
        return response()->json($response, 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->modelo->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $override = false)
    {
        $seccion_menu_descripcion = $this->tabla;
        $seccion_menu_data = $this->seccion_menu($seccion_menu_descripcion)->toArray();
        if(sizeof($seccion_menu_data) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no existe informacion seccion_menu',
            ];
            if($override)
            {
                return $response;
            }
            return response()->json($response, 500);
        }
        $seccion_menu = $seccion_menu_data[0];
        $seccion_menu_id = $seccion_menu['id'];
        $inputs_alta_data = $this->inputs($seccion_menu_id, 'alta')->toArray();
        if(sizeof($inputs_alta_data) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no existe informacion seccion_menu_input',
            ];
            if($override)
            {
                return $response;
            }
            return response()->json($response, 500);
        }
        foreach($inputs_alta_data as $key => $valor){
            $input_name = $valor['input_name'];
            if(trim((string)$request->input($input_name)) !== ''){
                $this->modelo->$input_name = $request->input($input_name);
            }
        }
        try{
            $this->modelo->save();
        }catch(\Exception $e){
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
            if($override)
            {
                return $response;
            }
            return response()->json($response, 500);
        }
        return $this->modelo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $registro = $this->modelo->find($id);
        if($registro){
            if(trim((string)$request->input('status')) !== ''){
                $registro->status = $request->input('status');
                $registro->save();
                return $registro;
            }
            $seccion_menu_descripcion = $this->tabla;
            $seccion_menu_data = $this->seccion_menu($seccion_menu_descripcion)->toArray();
            if(sizeof($seccion_menu_data) === 0){
                $response = [
                    'success' => false,
                    'message' => 'Error no existe informacion seccion_menu',
                ];
                return response()->json($response, 500);
            }
            $seccion_menu = $seccion_menu_data[0];
            $seccion_menu_id = $seccion_menu['id'];
            $inputs_modifica_data = $this->inputs($seccion_menu_id, 'modifica')->toArray();
            if(sizeof($inputs_modifica_data) === 0){
                $response = [
                    'success' => false,
                    'message' => 'Error no existe informacion seccion_menu_input',
                ];
                return response()->json($response, 500);
            }
            foreach($inputs_modifica_data as $key => $valor){
                $input_name = $valor['input_name'];
                if(trim((string)$request->input($input_name)) !== ''){
                    $registro->$input_name = $request->input($input_name);
                }
            }
            $registro->save();
            return $registro;
        }
        $response = [
            'success' => false,
            'message' => 'Error no existe registro',
        ];
        return response()->json($response, 500);
    }
}
