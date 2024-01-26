<?php

namespace App\Http\Traits;

use App\Models\SeccionMenu;

trait SeccionMenuTrait{
    /**
     * Retrieve data about seccion menu.
     *
     * @param  string $seccion_menu_descripcion
     * @return \Illuminate\Http\Response
     */
    public function seccion_menu_data(string $seccion_menu_descripcion){
        return SeccionMenu::select('seccion_menu.*')
            ->where('seccion_menu.descripcion', '=', $seccion_menu_descripcion)
            ->get();
    }
}