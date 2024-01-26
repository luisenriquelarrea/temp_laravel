<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UmaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'monto' => $this->faker->randomFloat(4, 100, 200),
            'fecha_inicio' => $this->faker->date(),
            'fecha_final' => $this->faker->date(),
        ];
    }
}
