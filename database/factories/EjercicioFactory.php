<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EjercicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descripcion' => date('Y')
        ];
    }
}
