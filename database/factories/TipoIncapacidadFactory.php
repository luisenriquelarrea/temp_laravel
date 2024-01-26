<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoIncapacidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => '001',
            'descripcion' => 'Incapacidad por maternidad',
        ];
    }
}
