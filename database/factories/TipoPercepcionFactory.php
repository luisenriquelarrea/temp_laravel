<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoPercepcionFactory extends Factory
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
            'descripcion' => 'Suedos, salarios, rayas y jornales',
        ];
    }
}
