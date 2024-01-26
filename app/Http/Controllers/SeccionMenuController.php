<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeccionMenu;
use App\Models\AccionBasica;
use App\Models\Accion;
use App\Http\Traits\SeccionMenuTrait;

class SeccionMenuController extends Controller
{
    use SeccionMenuTrait {
        seccion_menu_data as protected seccion_menu;
    }

    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SeccionMenu;
        $tabla = 'seccion_menu';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SeccionMenu::select(
            'seccion_menu.id AS seccion_menu_id', 
            'seccion_menu.descripcion AS seccion_menu_descripcion', 
            'seccion_menu.navbar_label AS seccion_menu_navbar_label', 
            'seccion_menu.icon AS seccion_menu_icon', 
            'menu.id AS menu_id', 
            'menu.descripcion AS menu_descripcion', 
            'menu.label AS menu_label', 
            'menu.icon AS menu_icon')
            ->join('menu', 'menu.id', '=', 'seccion_menu.menu_id')
            ->where('seccion_menu.status', '=', '1')
            ->where('menu.status', '=', '1')
            ->orderBy('menu.orden', 'ASC')
            ->get();
    }

    /**
     * Display a seccion_menu data.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_seccion_menu(Request $request)
    {
        $seccion_menu = $request->input('seccion_menu');
        return SeccionMenu::select(
            'seccion_menu.id AS seccion_menu_id', 
            'seccion_menu.descripcion AS seccion_menu_descripcion', 
            'seccion_menu.navbar_label AS seccion_menu_navbar_label', 
            'seccion_menu.icon AS seccion_menu_icon')
            ->where('seccion_menu.descripcion', '=', $seccion_menu)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $override = false)
    {
        $response = parent::store($request, true);
        if(isset($response['success']) && $response['success'] === false){
            return response()->json($response, 500);
        }
        $accion_basica = AccionBasica::select('accion_basica.*')
            ->where('accion_basica.status', '=', 1)
            ->get();
        if(sizeof($accion_basica) > 0)
        {
            foreach($accion_basica as $key => $valor){
                $accion_modelo = new Accion;
                $accion_modelo->seccion_menu_id = $response->id;
                $accion_modelo->descripcion = $valor['descripcion'];
                $accion_modelo->call_method = $valor['call_method'];
                $accion_modelo->label = $valor['label'];
                $accion_modelo->icon = $valor['icon'];
                $accion_modelo->on_table = $valor['on_table'];
                $accion_modelo->on_navbar = $valor['on_navbar'];
                $accion_modelo->save();
            }
        }
        return $response;
    }
}
