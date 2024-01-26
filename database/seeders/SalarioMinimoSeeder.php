<?php

namespace Database\Seeders;

use App\Models\SalarioMinimo;
use Illuminate\Database\Seeder;

class SalarioMinimoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalarioMinimo::factory()->create();
    }
}
