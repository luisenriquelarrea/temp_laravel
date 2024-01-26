<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExportacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => '02',
            'descripcion' => 'NO APLICA',
        ];
    }
}
