<?php

namespace Database\Factories;

use App\Models\TipoRegimen;
use App\Models\TipoNomina;
use App\Models\TipoContrato;
use App\Models\TipoJornada;
use App\Models\RiesgoPuesto;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoReciboFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_regimen_id' => TipoRegimen::first()->id,
            'tipo_nomina_id' => TipoNomina::first()->id,
            'tipo_contrato_id' => TipoContrato::first()->id,
            'tipo_jornada_id' => TipoJornada::first()->id,
            'riesgo_puesto_id' => RiesgoPuesto::first()->id,
            'codigo' => '001',
            'descripcion' => 'Sueldos y salarios',
        ];
    }
}
