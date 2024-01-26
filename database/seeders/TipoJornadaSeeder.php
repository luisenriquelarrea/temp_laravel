<?php

namespace Database\Seeders;

use App\Models\TipoJornada;
use Illuminate\Database\Seeder;

class TipoJornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoJornada::factory()->create();
    }
}
