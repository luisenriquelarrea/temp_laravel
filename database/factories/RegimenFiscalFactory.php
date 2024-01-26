<?php

namespace Database\Factories;

use App\Models\RegimenFiscal;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegimenFiscalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RegimenFiscal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'codigo' => rand(101, 999),
            'descripcion' => $this->faker->iso8601()
        ];
    }
}
