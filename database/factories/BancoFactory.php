<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BancoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => rand(101, 999),
            'descripcion' => 'AMEX',
            'razon_social'=> 'AMERICAN EXPRESS'
        ];
    }
}
