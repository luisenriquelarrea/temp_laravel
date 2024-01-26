<?php

namespace Database\Seeders;

use App\Models\PeriodicidadPago;
use Illuminate\Database\Seeder;

class PeriodicidadPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PeriodicidadPago::factory()->create();
    }
}
