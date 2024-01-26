<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalarioMinimoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'centro' => $this->faker->randomFloat(4, 200, 300),
            'frontera' => $this->faker->randomFloat(4, 300, 400),
            'fecha_inicio' => $this->faker->date(),
            'fecha_final' => $this->faker->date(),
        ];
    }
}
