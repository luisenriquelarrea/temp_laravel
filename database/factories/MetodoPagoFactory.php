<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetodoPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => 'PPD',
            'descripcion' => 'Pago en parcialidades o diferido',
        ];
    }
}
