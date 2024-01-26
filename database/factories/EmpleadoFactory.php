<?php

namespace Database\Factories;

use App\Models\Plaza;
use App\Models\Departamento;
use App\Models\Puesto;
use App\Models\RegimenFiscal;
use App\Models\PeriodicidadPago;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\CodigoPostal;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plaza_id' => Plaza::first()->id,
            'departamento_id' => Departamento::first()->id,
            'puesto_id' => Puesto::first()->id,
            'regimen_fiscal_id' => RegimenFiscal::first()->id,
            'periodicidad_pago_id' => PeriodicidadPago::first()->id,
            'pais_id' => Pais::first()->id,
            'estado_id' => Estado::first()->id,
            'municipio_id' => Municipio::first()->id,
            'codigo_postal_id' => CodigoPostal::first()->id,
            'nombre' => $this->faker->firstNameFemale(),
            'apellido_paterno' => $this->faker->lastName(),
            'apellido_materno' => $this->faker->lastName(),
            'nombre_completo' => $this->faker->firstNameFemale().' '.
                $this->faker->lastName().' '.$this->faker->lastName(),
            'rfc' => $this->faker->ein(),
            'curp' => $this->faker->ein(),
            'nss' => $this->faker->ssn(),
            'sexo' => 'F',
            'fecha_nacimiento' => $this->faker->date(),
            'telefono' => '3317885249',
            'email' => $this->faker->email(),
            'colonia' => $this->faker->city(),
            'domicilio' => $this->faker->address(),
            'salario_base' => $this->faker->randomFloat(4, 3000, 5000),
            'salario_diario' => $this->faker->randomFloat(4, 3000, 5000),
            'salario_diario_integrado' => $this->faker->randomFloat(4, 3000, 5000),
            'salario_asimilados' => $this->faker->randomFloat(4, 3000, 5000),
            'fecha_inicio_laboral' => $this->faker->date(),
            'fecha_alta_imss' => $this->faker->date(),
            'numero_infonavit' =>$this->faker->randomNumber(8, true),
            'pago_infonavit' => $this->faker->randomFloat(4, 1000, 2000),
        ];
    }
}
