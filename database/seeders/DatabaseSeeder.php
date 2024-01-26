<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BancoSeeder::class,
            DepartamentoSeeder::class,
            EjercicioSeeder::class,
            ExportacionSeeder::class,
            FormaPagoSeeder::class,
            MesSeeder::class,
            MetodoPagoSeeder::class,
            MonedaSeeder::class,
            MotivoCancelacionSeeder::class,
            PaisSeeder::class,
            EstadoSeeder::class,
            MunicipioSeeder::class,
            CodigoPostalSeeder::class,
            PeriodicidadPagoSeeder::class,
            PeriodoPagoSeeder::class,
            PlazaSeeder::class,
            PuestoSeeder::class,
            RegimenFiscalSeeder::class,
            EmpleadoSeeder::class,
            EmpresaSeeder::class,
            EmpresaCuentaBancariaSeeder::class,
            EmpleadoEmpresaSeeder::class,
            RegistroPatronalSeeder::class,
            RiesgoPuestoSeeder::class,
            SalarioMinimoSeeder::class,
            TipoCambioSeeder::class,
            TipoComprobanteSeeder::class,
            TipoContratoSeeder::class,
            TipoDeduccionSeeder::class,
            DeduccionSeeder::class,
            TipoIncapacidadSeeder::class,
            TipoJornadaSeeder::class,
            TipoNominaSeeder::class,
            TipoRegimenSeeder::class,
            TipoOtroPagoSeeder::class,
            TipoPercepcionSeeder::class,
            TipoReciboSeeder::class,
            EmpleadoCuentaBancariaSeeder::class,
            UmaSeeder::class,
            UnidadSeeder::class,
            UsoCfdiSeeder::class,
        ]);
    }
}
