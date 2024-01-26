<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MonedaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => $this->faker->currencyCode(),
            'descripcion' => $this->faker->currencyCode()
        ];
    }
}
