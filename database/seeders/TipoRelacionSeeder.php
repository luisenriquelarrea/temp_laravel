<?php

namespace Database\Seeders;

use App\Models\TipoRelacion;
use Illuminate\Database\Seeder;

class TipoRelacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRelacion::factory()->create();
    }
}
