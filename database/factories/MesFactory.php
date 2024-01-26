<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => '01',
            'descripcion' => 'ENERO',
        ];
    }
}
