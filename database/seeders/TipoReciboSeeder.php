<?php

namespace Database\Seeders;

use App\Models\TipoRecibo;
use Illuminate\Database\Seeder;

class TipoReciboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRecibo::factory()->create();
    }
}
