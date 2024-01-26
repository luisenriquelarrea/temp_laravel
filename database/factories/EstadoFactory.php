<?php

namespace Database\Factories;

use App\Models\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pais_id' => Pais::first()->id,
            'codigo' => $this->faker->stateAbbr(),
            'descripcion' => $this->faker->state()
        ];
    }
}
