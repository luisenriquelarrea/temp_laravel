<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeccionMenuInput;
use App\Http\Traits\SeccionMenuInputTrait;

class SeccionMenuInputController extends Controller
{
    use SeccionMenuInputTrait {
        get_inputs as protected inputs;
    }

    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SeccionMenuInput;
        $tabla = 'seccion_menu_input';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SeccionMenuInput::select('seccion_menu_input.*', 'seccion_menu.descripcion AS seccion_menu_descripcion')
            ->join('seccion_menu', 'seccion_menu.id', '=', 'seccion_menu_input.seccion_menu_id')
            ->orderBy('seccion_menu_input.id', 'ASC')
            ->get();
    }

    /**
     * Display a listing of the seccion_menu inputs.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_inputs_alta(Request $request)
    {
        $seccion_menu_id = $request->input('seccion_menu_id');
        $column = 'alta';
        return $this->inputs($seccion_menu_id, $column);
    }

    /**
     * Display a listing of the seccion_menu inputs filtro.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_inputs_filtro(Request $request)
    {
        $seccion_menu_id = $request->input('seccion_menu_id');
        $column = 'filtro';
        return $this->inputs($seccion_menu_id, $column);
    }

    /**
     * Display a listing of the seccion_menu inputs rendering modifica template.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_inputs_modifica(Request $request)
    {
        $seccion_menu_id = $request->input('seccion_menu_id');
        $column = 'modifica';
        return $this->inputs($seccion_menu_id, $column);
    }

    /**
     * Get columns to display in table.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_table_columns(Request $request)
    {
        $seccion_menu_id = $request->input('seccion_menu_id');
        $column = 'lista';
        return $this->inputs($seccion_menu_id, $column);
    }
}
