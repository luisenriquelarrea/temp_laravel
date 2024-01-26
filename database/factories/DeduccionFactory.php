<?php

namespace Database\Factories;

use App\Models\TipoDeduccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeduccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_deduccion_id' => TipoDeduccion::first()->id,
            'descripcion' => 'PRESTAMO SOFOM'
        ];
    }
}
