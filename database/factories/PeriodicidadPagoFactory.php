<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodicidadPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => '02',
            'descripcion' => 'SEMANAL',
            'n_elementos' => '7'
        ];
    }
}
