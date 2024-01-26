<?php

namespace Database\Seeders;

use App\Models\EmpleadoCuentaBancaria;
use Illuminate\Database\Seeder;

class EmpleadoCuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmpleadoCuentaBancaria::factory()->create();
    }
}
