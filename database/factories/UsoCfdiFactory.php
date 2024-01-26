<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsoCfdiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => 'G03',
            'descripcion' => 'Gastos en general',
        ];
    }
}
