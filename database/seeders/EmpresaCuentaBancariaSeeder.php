<?php

namespace Database\Seeders;

use App\Models\EmpresaCuentaBancaria;
use Illuminate\Database\Seeder;

class EmpresaCuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmpresaCuentaBancaria::factory()->create();
    }
}
