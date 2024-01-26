<?php

namespace Database\Seeders;

use App\Models\TipoNomina;
use Illuminate\Database\Seeder;

class TipoNominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoNomina::factory()->create();
    }
}
