<?php

namespace App\Services;

use App\Models\SeccionMenu;
use App\Models\AccionBasica;
use App\Models\Grupo;

class SeccionMenuService
{
    public function deploy_accion_grupo(array $data): SeccionMenu
    {
        $seccion = SeccionMenu::create($data);

        $accionesBasicas = AccionBasica::all();

        $accionesCreadas = $accionesBasicas->map(function ($accion_basica) use ($seccion) {
            return $seccion->acciones()->create([
                'descripcion' => $accion_basica->descripcion,
                'call_method' => $accion_basica->call_method,
                'label' => $accion_basica->label,
                'icon' => $accion_basica->icon,
                'on_breadcrumb' => $accion_basica->on_breadcrumb,
                'on_navbar' => $accion_basica->on_navbar,
                'on_table' => $accion_basica->on_table,
            ]);
        });

        $grupoAdmin = Grupo::where('descripcion', 'administrador')->first();

        if ($grupoAdmin) {
            $grupoAdmin->acciones()->attach(
                $accionesCreadas->pluck('id')->toArray()
            );
        }

        return $seccion;
    }
}