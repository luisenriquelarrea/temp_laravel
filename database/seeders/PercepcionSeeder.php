<?php

namespace Database\Seeders;

use App\Models\Percepcion;
use Illuminate\Database\Seeder;

class PercepcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Percepcion::factory()->create();
    }
}
