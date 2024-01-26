<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Plaza;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroPatronalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'plaza_id' => Plaza::first()->id,
            'descripcion' => $this->faker->ein()
        ];
    }
}
