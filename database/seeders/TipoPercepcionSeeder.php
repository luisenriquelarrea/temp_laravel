<?php

namespace Database\Seeders;

use App\Models\TipoPercepcion;
use Illuminate\Database\Seeder;

class TipoPercepcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPercepcion::factory()->create();
    }
}
