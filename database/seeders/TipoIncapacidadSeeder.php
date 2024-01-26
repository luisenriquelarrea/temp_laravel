<?php

namespace Database\Seeders;

use App\Models\TipoIncapacidad;
use Illuminate\Database\Seeder;

class TipoIncapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoIncapacidad::factory()->create();
    }
}
