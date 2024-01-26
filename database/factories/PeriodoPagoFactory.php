<?php

namespace Database\Factories;

use App\Models\PeriodicidadPago;
use App\Models\Ejercicio;
use App\Models\Mes;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodoPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'periodicidad_pago_id' => PeriodicidadPago::first()->id,
            'ejercicio_id' => Ejercicio::first()->id,
            'mes_id' => Mes::first()->id,
            'descripcion' => 'SEMANAL',
            'fecha_inicio' => $this->faker->date(),
            'fecha_final' => $this->faker->date(),
            'fecha_pago' => $this->faker->date()
        ];
    }
}
