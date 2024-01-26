<?php

namespace Database\Seeders;

use App\Models\Exportacion;
use Illuminate\Database\Seeder;

class ExportacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exportacion::factory()->create();
    }
}
