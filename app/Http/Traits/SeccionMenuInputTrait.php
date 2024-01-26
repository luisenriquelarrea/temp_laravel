<?php

namespace App\Http\Traits;

use App\Models\SeccionMenuInput;

trait SeccionMenuInputTrait{
    /**
     * Retrieve inputs alta form.
     *
     * @param  int $seccion_menu_id
     * @param  string $column
     * @return \Illuminate\Http\Response
     */
    public function get_inputs(int $seccion_menu_id, string $column){
        return SeccionMenuInput::select('seccion_menu_input.*')
            ->where('seccion_menu_input.seccion_menu_id', '=', $seccion_menu_id)
            ->where('seccion_menu_input.status', '=', 1)
            ->where('seccion_menu_input.'.$column, '=', 1)
            ->join('seccion_menu', 'seccion_menu_input.seccion_menu_id', 
                '=', 'seccion_menu.id')
            ->orderBy('seccion_menu_input.orden', 'ASC')
            ->get();
    }
}