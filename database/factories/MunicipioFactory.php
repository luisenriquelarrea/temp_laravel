<?php

namespace Database\Factories;

use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class MunicipioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado_id' => Estado::first()->id,
            'codigo' => $this->faker->citySuffix(),
            'descripcion' => $this->faker->city()
        ];
    }
}
