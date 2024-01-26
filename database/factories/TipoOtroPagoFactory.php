<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoOtroPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => '002',
            'descripcion' => 'Subsidio para el empleo',
        ];
    }
}
