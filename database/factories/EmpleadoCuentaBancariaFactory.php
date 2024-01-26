<?php

namespace Database\Factories;

use App\Models\Banco;
use App\Models\Empleado;
use App\Models\TipoRecibo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoCuentaBancariaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'empleado_id' => Empleado::first()->id,
            'tipo_recibo_id' => TipoRecibo::first()->id,
            'banco_id' => Banco::first()->id,
            'cuenta' => '01478596879',
            'numero_tarjeta' => '415231378745'.rand(1000, 9999),
            'clabe_interbancaria' => '0123'.'415231378745'.rand(10, 99)
        ];
    }
}
