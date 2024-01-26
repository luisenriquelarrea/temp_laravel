<?php

namespace Database\Factories;

use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodigoPostalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'municipio_id' => Municipio::first()->id,
            'descripcion' => $this->faker->postcode()
        ];
    }
}
