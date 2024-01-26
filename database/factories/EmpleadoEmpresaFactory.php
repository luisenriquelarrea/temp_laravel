<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Plaza;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoEmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empleado_id' => Empleado::first()->id,
            'plaza_id' => Plaza::first()->id,
            'empresa_sueldos_id' => Empresa::first()->id,
            'empresa_contable_id' => Empresa::first()->id,
            'empresa_asimilados_id' => Empresa::first()->id,
        ];
    }
}
