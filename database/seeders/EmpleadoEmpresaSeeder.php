<?php

namespace Database\Seeders;

use App\Models\EmpleadoEmpresa;
use Illuminate\Database\Seeder;

class EmpleadoEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmpleadoEmpresa::factory()->create();
    }
}
