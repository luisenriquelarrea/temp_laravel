<?php

namespace Database\Factories;

use App\Models\TipoPercepcion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PercepcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_percepcion_id' => TipoPercepcion::first()->id,
            'descripcion' => 'SUELDOS Y SALARIOS'
        ];
    }
}
