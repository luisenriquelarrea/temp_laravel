<?php

namespace Database\Seeders;

use App\Models\PeriodoPago;
use Illuminate\Database\Seeder;

class PeriodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PeriodoPago::factory()->create();
    }
}
