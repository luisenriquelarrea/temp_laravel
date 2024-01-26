<?php

namespace Database\Seeders;

use App\Models\TipoDeduccion;
use Illuminate\Database\Seeder;

class TipoDeduccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDeduccion::factory()->create();
    }
}
