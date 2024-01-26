<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccionGrupo;

class AccionGrupoController extends Controller
{
    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new AccionGrupo;
        $tabla = 'accion_grupo';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a seccion_menu data by descripcion.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_allowed_menus(Request $request)
    {
        if((string)trim($request->input['grupo_id']) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[grupo_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        $grupo_id = $request->input('grupo_id');
        $accion_grupo = AccionGrupo::select('menu.label AS menu_label', 'menu.icon AS menu_icon', 'menu.orden AS menu_orden', 
            'seccion_menu.descripcion AS seccion_menu_descripcion', 'seccion_menu.navbar_label AS seccion_menu_navbar_label')
            ->join('grupo', 'grupo.id', '=', 'accion_grupo.grupo_id')
            ->join('accion', 'accion.id', '=', 'accion_grupo.accion_id')
            ->join('seccion_menu', 'seccion_menu.id', '=', 'accion.seccion_menu_id')
            ->join('menu', 'menu.id', '=', 'seccion_menu.menu_id')
            ->where('accion_grupo.grupo_id', '=', $grupo_id)
            ->where('grupo.status', '=', 1)
            ->where('accion.status', '=', 1)
            ->where('seccion_menu.status', '=', 1)
            ->where('menu.status', '=', 1)
            ->where('accion.on_navbar', '=', 1)
            ->groupBy('seccion_menu.id')
            ->orderBy('menu.orden', 'ASC')
            ->get();
        if($accion_grupo->isEmpty()){
            $response = [
                'success' => false,
                'message' => 'Error no hay informacion en accion_grupo',
            ];
            return response()->json($response, 500);
        }
        $accion_grupo = json_decode($accion_grupo, true);
        $accion_grupo = $this->group_data($accion_grupo, 'menu_label');
        return json_encode($accion_grupo);
    }

    /**
     * Get allowed navbar permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_allowed_navbar(Request $request){
        if((string)trim($request->input('grupo_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[grupo_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        if((string)trim($request->input('seccion_menu_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[seccion_menu_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        $grupo_id = $request->input('grupo_id');
        $seccion_menu_id = $request->input('seccion_menu_id');
        return AccionGrupo::select('accion_grupo.id AS accion_grupo_id',
                'accion.descripcion', 'accion.label', 'accion.icon', 
                'accion.call_method')
            ->join('accion', 'accion.id', '=', 'accion_grupo.accion_id')
            ->where('accion_grupo.grupo_id', '=', $grupo_id)
            ->where('accion_grupo.status', '=', 1)
            ->where('accion.seccion_menu_id', '=', $seccion_menu_id)
            ->where('accion.status', '=', 1)
            ->where('accion.on_navbar', '=', 1)
            ->get();
    }

    /**
     * Get allowed table permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_allowed_table_actions(Request $request){
        if((string)trim($request->input('grupo_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[grupo_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        if((string)trim($request->input('seccion_menu_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[seccion_menu_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        $grupo_id = $request->input('grupo_id');
        $seccion_menu_id = $request->input('seccion_menu_id');
        return AccionGrupo::select('accion_grupo.id AS accion_grupo_id',
                'accion.descripcion', 'accion.label', 'accion.icon', 
                'accion.call_method')
            ->join('accion', 'accion.id', '=', 'accion_grupo.accion_id')
            ->where('accion_grupo.grupo_id', '=', $grupo_id)
            ->where('accion_grupo.status', '=', 1)
            ->where('accion.seccion_menu_id', '=', $seccion_menu_id)
            ->where('accion.status', '=', 1)
            ->where('accion.on_table', '=', 1)
            ->get();
    }

    /**
     * Get allowed XLS button permission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_xls_button(Request $request){
        if((string)trim($request->input('grupo_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[grupo_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        if((string)trim($request->input('seccion_menu_id')) === ''){
            $response = [
                'success' => false,
                'message' => 'Error $request->input[seccion_menu_id] debe estar asignado',
            ];
            return response()->json($response);
        }
        $grupo_id = $request->input('grupo_id');
        $seccion_menu_id = $request->input('seccion_menu_id');
        return AccionGrupo::select('accion_grupo.id AS accion_grupo_id',
                'accion.descripcion', 'accion.label', 'accion.icon', 
                'accion.call_method')
            ->join('accion', 'accion.id', '=', 'accion_grupo.accion_id')
            ->where('accion_grupo.grupo_id', '=', $grupo_id)
            ->where('accion_grupo.status', '=', 1)
            ->where('accion.seccion_menu_id', '=', $seccion_menu_id)
            ->where('accion.status', '=', 1)
            ->where('accion.descripcion', '=', 'xls')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AccionGrupo::select('grupo.descripcion AS grupo_descripcion', 'accion.descripcion AS accion_descripcion')
            ->join('grupo', 'grupo.id', '=', 'accion_grupo.grupo_id')
            ->join('accion', 'accion.id', '=', 'accion_grupo.accion_id')
            ->orderBy('grupo.id', 'ASC')
            ->get();
    }
}
