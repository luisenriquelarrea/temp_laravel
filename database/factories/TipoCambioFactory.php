<?php

namespace Database\Factories;

use App\Models\Moneda;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoCambioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'moneda_id' => Moneda::first()->id,
            'descripcion' => 'MXN',
            'fecha' => $this->faker->date(),
            'monto' => '1.0000'
        ];
    }
}
